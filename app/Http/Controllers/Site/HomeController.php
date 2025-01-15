<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Accreditation;
use App\Models\Career;
use App\Models\Category;
use App\Models\Charter;
use App\Models\City;
use App\Models\Complaint;
use App\Models\Enlightenment;
use App\Models\HealthyEating;
use App\Models\InstituteCategory;
use App\Models\Laboratory;
use App\Models\LaboratoryCategory;
use App\Models\LeaderShip;
use App\Models\News;
use App\Models\Position;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Structure;
use App\Models\TariffCategory;
use App\Models\Useful;
use App\Models\UsefulCategory;
use App\Models\UsefulLink;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class HomeController extends Controller
{
    protected $currentLang;

    public function __construct()
    {
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }

    public function index()
    {
        $currentLang = $this->currentLang;
        $sliders = Slider::where(['status' => 1])->orderBy('id','DESC')->first();
        $newsCategory = Category::with('news')->where(['status' => 1])->first();
        $news = News::where(['is_main' => 1,'status' =>1,'category_id' => $newsCategory['id']])->orderBy('datetime','DESC')->offset(0)->limit(2)->get();
        $services = Service::where('status', 1)->get();
        $usefulLink = UsefulLink::where('status', 1)->get();
        $tariffCategory = TariffCategory::where(['status' => 1])->get();
        $about = About::orderBy('id','DESC')->first();
        $leaderShip = LeaderShip::where(['status' => 1])->with('position','parent')->get();
        return view('site.home',compact('currentLang','sliders','newsCategory','news','services','usefulLink','tariffCategory','about','leaderShip'));
    }

    public function about()
    {
        $currentLang = $this->currentLang;
        $about = About::orderBy('id','DESC')->first();
        return view('site.about',compact('currentLang','about'));
    }

    public function team()
    {
        $currentLang = $this->currentLang;
        $leaderShip = LeaderShip::where(['status' => 1])->with('position','parent')->get();
        return view('site.team',compact('currentLang','leaderShip'));
    }

    public function portfolio()
    {
        $currentLang = $this->currentLang;
        $projects = Useful::where(['status' => 1])->with(['category','parentCategory','subParentCategory'])->orderBy('id','DESC')->get();
        return view('site.portfolio',compact('currentLang','projects'));
    }

    public function portfolioDetail($slug)
    {
        $currentLang = $this->currentLang;
        $portfolio = Useful::where(['status' => 1,'slug->'.$this->currentLang => $slug])->with(['category','parentCategory','subParentCategory'])->first();
        if (empty($portfolio['id'])){
            return self::notFound();
        }
        return view('site.portfolio-detail',compact('currentLang','portfolio'));
    }

    public function news()
    {
        $currentLang = $this->currentLang;
        $newsCategory = Category::with('news')->where(['status' => 1])->first();
        $news = News::where(['status' =>1,'category_id' => $newsCategory['id']])->orderBy('datetime','DESC')->get();
        return view('site.news',compact('currentLang','news','newsCategory'));
    }

    public function newsDetails($slug)
    {
        $currentLang = $this->currentLang;
        /*$newsCategory = Category::with('news')->where(['status' => 1,'slug->'.$this->currentLang => $catSlug])->first();
        if (empty($newsCategory['id']) || empty($newsCategory['news'][0])){
            return self::notFound();
        }*/
        $news = News::where(['status' => 1,'slug->'.$this->currentLang => $slug/*,'category_id' => $newsCategory['id']*/])->first();
        if (empty($news['id'])){
            return self::notFound();
        }
        return view('site.news-details',compact('currentLang',/*'newsCategory',*/'news'));
    }

    public function service($slug){
        $currentLang = $this->currentLang;
        $service = Service::where(['status' => 1, 'slug->'.$this->currentLang => $slug])->first();
        if (empty($service['id'])){
            return self::notFound();
        }
        return view('site.service',compact('currentLang','service'));
    }

    public function contact(){
        $currentLang = $this->currentLang;
        $setting = Setting::first();
        return view('site.contact',compact('currentLang','setting'));
    }

    public function search(Request $request)
    {
        $currentLang = $this->currentLang;
        $search = $request->get('q');

        // News sonuçları
        $newsResults = News::with('category')->where('title', 'like', '%' . $search . '%')
            ->get()
            ->map(function ($item) {
                $item->link = route('site.newsDetails', [
                    'catSlug' => $item['category']['slug'][$this->currentLang],
                    'slug' => $item['slug'][$this->currentLang]
                ]); // News
                $item->category = $item['category']['title'][$this->currentLang];
                return $item;
            });

        // Enlightenment sonuçları
        $enlightenmentResults = Enlightenment::where('title', 'like', '%' . $search . '%')
            ->get() ->map(function ($item) {
                $item->link = route('site.enlightenmentDetails', [
                    'slug' => $item['slug'][$this->currentLang]
                ]);
                return $item;
            });

        // Laboratory sonuçları
        $laboratoryResults = Laboratory::where('title', 'like', '%' . $search . '%')
            ->get()->map(function ($item) {
                $item->link = route('site.laboratoryDetails', [
                    'catSlug' => $item['laboratoryCategory']['slug'][$this->currentLang],
                    'slug' => $item['slug'][$this->currentLang]
                ]);
                $item->category = $item['laboratoryCategory']['title'][$this->currentLang];
                return $item;
            });

        // Useful sonuçları
        $usefulResults = Useful::where('title->'.$this->currentLang, 'LIKE', '%' . $search . '%')/*->where(['page_type' => 'image_content'])*/
            ->get()->map(function ($item) {
                $item->link = !empty($item['file'])? asset('uploads/useful/file/'.$item->file) :route('site.usefulDetail', [
                    'catSlug' => $item['category']['slug'][$this->currentLang],
                    'slug' => $item['slug'][$this->currentLang]
                ]);
                $item->category = $item['category']['title'][$this->currentLang];
                return $item;
            });

        // Service sonuçları
        $serviceResults = Service::where('title->'.$this->currentLang, 'LIKE', '%' . $search . '%')/*->where(['page_type' => 'image_content'])*/
            ->get()->map(function ($item) {
                $item->link =  route('site.service', [
                    'slug' => $item['slug'][$this->currentLang]
                ]);
                return $item;
            });
//            dd($usefulResults);
        // Sonuçları birleştir
        $results = $newsResults->merge($enlightenmentResults)->merge($laboratoryResults)->merge($usefulResults)->merge($serviceResults);

//        dd($results);
        return view('site.search', compact('currentLang', 'results'));
    }

    public function notPage()
    {
        $currentLang = $this->currentLang;
        return view('errors.404',compact('currentLang'));
    }

    public function notFound()
    {
        $currentLang = $this->currentLang;
        return view('site.not_found',compact('currentLang'));
    }
}
