<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;

class AccreditationHelper
{
    public static function data($request,$accreditation,$instituteCategoryId)
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
            $request->image->move(public_path('uploads/institute/accreditation'), $image);
        }else{
            $image = !empty($accreditation->image)? $accreditation->image: NULL;
        }

        $data = [
            'category_id' => $instituteCategoryId,
            'image' => $image,
            'title' => $title,
            'slug' => $slug,
            'status' => $request->status,
        ];

        return $data;
    }
}
