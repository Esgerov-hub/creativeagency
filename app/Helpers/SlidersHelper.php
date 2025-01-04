<?php

namespace App\Helpers;

use App\Models\Translation;

class SlidersHelper
{
    public static function data($request,$slider = null)
    {
        $locales = Translation::where('status',1)->get();
        $title = []; $text = [];

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $text[$code] = $request->input("text.".$code, '');
        }

        if($request->hasFile('image')){
            $image = time().$request->image->extension();
            $request->image->move(public_path('uploads/sliders'), $image);
        }else{
            $image = !empty($slider->image)? $slider->image: NULL;
        }

        $data = [
            'image' => $image,
            'link' => $request->link,
            'title' => $title,
            'text' => $text,
            'status' => $request->status,
        ];

        return $data;
    }
}
