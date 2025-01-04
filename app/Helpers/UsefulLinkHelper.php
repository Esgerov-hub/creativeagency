<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;

class UsefulLinkHelper
{
    public static function data($request, $usefulLink = null)
    {
        $locales = Translation::where('status',1)->get();
        $title = []; $slug = [];

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $slug[$code] = Str::slug(trim($request->input("title.".$code, '')));
        }
        if($request->hasFile('image')){
            $image = time().$request->image->extension();
            $request->image->move(public_path('uploads/usefulLink'), $image);
        }else{
            $image = !empty($usefulLink->image)? $usefulLink->image: NULL;
        }
        $data = [
            'title' => $title,
            'image' => $image,
            'slug' => $slug,
            'link' => $request->link,
            'status' => $request->status,
        ];

        return $data;
    }
}
