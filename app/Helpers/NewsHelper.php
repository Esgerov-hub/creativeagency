<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;

class NewsHelper
{
    public static function data($request,$news = null)
    {

        $locales = Translation::where('status',1)->get();
        $title = []; $text = []; $fulltext = []; $slug = [];

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $slug[$code] = Str::slug(trim($request->input("title.".$code, '')));
            $text[$code] = $request->input("text.".$code, '');
            $fulltext[$code] = $request->input("fulltext.".$code, '');
        }

        if($request->hasFile('image')){
            $image = time().$request->image->extension();
            $request->image->move(public_path('uploads/news'), $image);
        }else{
            $image = !empty($news->image)? $news->image: NULL;
        }

        $slider_images = [];
        if ($request->hasFile('slider_image')) {
            foreach ($request->file('slider_image') as $slider_image) {
                if ($slider_image->isValid()) {
                    // Resmi kaydet
                    $filename = time() . '-' . $slider_image->getClientOriginalName();
                    $slider_image->move(public_path('uploads/news/slider_image'), $filename);
                    $slider_images[] = $filename;
                }
            }
        }
        $data = [
            'category_id' => $request->category_id,
            'image' => $image,
            'slider_image' => empty($slider_images[0])? $news->slider_image: $slider_images,
            'title' => $title,
            'slug' => $slug,
            'text' => $text,
            'fulltext' => $fulltext,
            'status' => $request->status,
            'is_main' => $request->is_main,
            'datetime' => date('Y-m-d H:i:s',strtotime($request->datetime)),
        ];

        return $data;
    }
}
