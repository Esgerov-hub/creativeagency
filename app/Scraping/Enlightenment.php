<?php
namespace App\Scraping;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class Enlightenment
{
    public  function scrape($limit = 100, $postLimit = 100)
    {
        // Implement scraping logic for HelloJob website
        $site = 'https://afsi.gov.az/az/media/maariflndirm/1';
        $client = $this->initializeHttpClient();
        $response = $client->get($site);
        $htmlContent = $response->body();
        $crawler = new Crawler($htmlContent);
        $resoult = [];
        $classes = $crawler->filter('.li_right_div');
        $classes->each(function ($class) use (&$resoult, $client, $limit, $postLimit) {
            if (count($resoult) >= $limit) {
                return false; // Stop the loop if the limit is reached
            }
            $links = $class->filter('a');
            $links->each(function ($link) use (&$resoult, $client, $postLimit) {
                if (count($resoult) < $postLimit) {
                    $url = $link->attr('href');

                    $jobUrl = 'https://afsi.gov.az/' . $url;
                    $jobUrl = $this->url($client, $jobUrl);
                    if ($jobUrl) {
                        $resoult[] = $jobUrl;
                    }
                }
            });
        });

        // Process the result as needed
        return $resoult;
    }

    // You can include the rest of the methods from HelloJobController@data here
    private function initializeHttpClient()
    {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
        return Http::withHeaders(['User-Agent' => $userAgent]);
    }

    private function url($client, $url)
    {
//        $url = 'https://afsi.gov.az/az/media/xeberler/aqti-qida-mhsullarinda-rf-omrunun-tyini-sinaqlarini-hyata-kecirck';
        $url = $client->get($url);
        try {
            if ($url->successful()) {
                $pageContent = $url->body();

                $data = [];
                $crawler = new Crawler($pageContent);
                $title = $crawler->filter('.full .sened_top_span')->text();
                $datetime = $crawler->filter('.full .news_date')->text();
                $paragraphs = $crawler->filter('.content_div.full p')->each(function (Crawler $node, $i) {
                    if ($i >= 1) { // İkinci p elementindən başlayaraq götür
                        return $node->outerHtml();
                    }
                    return null;
                });
                $filteredParagraphs = array_filter($paragraphs);

                $fulltext = implode("\n", $filteredParagraphs);
                $imagesUrl = $crawler->filter('.content_slider img')->each(function (Crawler $node) {
                    return $node->attr('src');
                });
                $text = !empty($filteredParagraphs[0])? strip_tags($filteredParagraphs[0]): strip_tags($filteredParagraphs[1]);

                $image = '';
                if (!empty($imagesUrl[0])) {
                    $imageData = @file_get_contents('https://afsi.gov.az/'.$imagesUrl[0]);
                    if ($imageData === false) {
                        // Hata durumunda bildirim
                        Log::error("Şəkil URL'den veri alınamadı: $imagesUrl");
                    } else {
                        // Dosya uzantısını al
                        $extension = pathinfo($imagesUrl[0], PATHINFO_EXTENSION);
                        // Dosya adını tanımla
                        $fileName = 'uploads/enlightenment/' . preg_replace('/\s+/', '-', mb_strtolower($title, 'UTF-8')) . '.' . $extension;
                        $directory = dirname($fileName);

                        if (!file_exists($directory)) {
                            if (!mkdir($directory, 0777, true)) {
                                Log::error("Klasör oluşturulamadı: $directory");
                                dd('Klasör oluşturma hatası');
                            }
                        }

                        // Dosyaya veriyi yaz
                        if (file_put_contents($fileName, $imageData) !== false) {
                            $image = preg_replace('/\s+/', '-', mb_strtolower($title, 'UTF-8')) . '.' . $extension;
                            Log::error("Şəkil dosyaya kaydedilemedi: $image");
                        } else {
                            // Hata durumunda bildirim
                            Log::error("Şəkil dosyaya kaydedilemedi: $fileName");
                        }
                    }

                }

                $sliderImages = []; // Array olarak tanımlandı
                if (!empty($imagesUrl[0])) {
                    foreach ($imagesUrl as $sliderUrl) {
                        $sliderImageData = @file_get_contents('https://afsi.gov.az/' . $sliderUrl);

                        if ($sliderImageData === false) {
                            Log::error("Şəkil URL'den veri alınamadı: $sliderUrl");
                        } else {
                            $extension = pathinfo($sliderUrl, PATHINFO_EXTENSION);
                            $uniqueName = preg_replace('/\s+/', '-', mb_strtolower($title, 'UTF-8')) . '-' . uniqid();
                            $fileName = 'uploads/enlightenment/slider_image/' . $uniqueName . '.' . $extension;

                            $directory = dirname($fileName);
                            if (!file_exists($directory)) {
                                if (!mkdir($directory, 0777, true)) {
                                    Log::error("Klasör oluşturulamadı: $directory");
                                }
                            }

                            if (file_put_contents($fileName, $sliderImageData) !== false) {
                                $sliderImages[] = $uniqueName . '.' . $extension; // Benzersiz isim diziye eklenir
                            } else {
                                Log::error("Şəkil dosyaya kaydedilemedi: $fileName");
                            }
                        }
                    }
                }

                $data = [
                    'title' => $title,
                    'text' => $text,
                    'fulltext' => $fulltext,
                    'image' => $image,
                    'slider_image' => $sliderImages,
                    'datetime' => $datetime,
                ];

                if (!empty($data)) {
                    $dataSave = self::dataSave($data);
                    return $dataSave;
                } else {
                    return $data;
                }
            }
        } catch (\Exception $e) {
            // Log the exception or handle it in some way
            Log::info('Exception: ' . $e->getMessage());
        }
    }


    public static function dataSave($data)
    {
        $response = [];
        try {
            if (!empty($data) && $data != NULL) {
                $title = $data['title'];
                $text = $data['text'];
                $fullText = $data['fulltext'];
                $enlightenmentTitle = ['az' => $title,'en' => '','ru' => ''];
                $enlightenmentSlug = ['az' => Str::slug($title),'en' => '','ru' => ''];
                $enlightenmentText = ['az' => $text,'en' => '','ru' => ''];
                $enlightenmentFullText= ['az' => $fullText,'en' => '','ru' => ''];
                $enlightenment = new \App\Models\Enlightenment();
                $enlightenment->title = $enlightenmentTitle;
                $enlightenment->slug = $enlightenmentSlug;
                $enlightenment->text = $enlightenmentText;
                $enlightenment->fulltext = $enlightenmentFullText;
                $enlightenment->image = $data['image'];
                $enlightenment->slider_image = $data['slider_image'];
                $enlightenment->datetime = date('Y-m-d H:i:s',strtotime($data['datetime']));
                $enlightenment->status = 1;
                $enlightenment->is_main = 0;
                $enlightenment->order_by = 0;
                $enlightenment->save();
                $response = [
                    'success' => true,
                    'message' => 'Məlumat bazaya yazıldı.',
                    'code' => 200
                ];

                // end news
                return $response;
            } else {
                return [
                    'success' => false,
                    'message' => 'Məlumat boş olduqu üçün bazaya heçnə yazılmadı.',
                    'code' => 422
                ];
            }
        } catch (\Exception $e) {
            Log::info('Exception: ' . $e->getMessage());
        }
    }
}
