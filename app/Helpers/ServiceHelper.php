<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;

class ServiceHelper
{
    public static function data($request,$news = null)
    {

        $locales = Translation::where('status',1)->get();
        $title = []; $text = []; $slug = [];

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $slug[$code] = Str::slug(trim($request->input("title.".$code, '')));
            $text[$code] = $request->input("text.".$code, '');
        }

        if($request->hasFile('image')){
            $image = time().$request->image->extension();
            $request->image->move(public_path('uploads/services'), $image);
        }else{
            $image = !empty($news->image)? $news->image: NULL;
        }

        $data = [
            'image' => $image,
            'title' => $title,
            'slug' => $slug,
            'text' => $text,
            'status' => $request->status
        ];

        return $data;
    }
}
