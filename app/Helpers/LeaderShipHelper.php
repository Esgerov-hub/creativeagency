<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;

class LeaderShipHelper
{
    public static function data($request,$leadership,$instituteCategoryId)
    {
        $locales = Translation::where('status',1)->get();
        $full_name = []; $fulltext = []; $slug = [];
        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $full_name[$code] = $request->input("full_name.".$code, '');
            $slug[$code] = Str::slug(trim($request->input("fullname.".$code, '')));
            $fulltext[$code] = $request->input("fulltext.".$code, '');
            $reception_days[$code] = $request->input("reception_days.".$code, '');
        }
        if($request->hasFile('image')){
            $image = time().$request->image->extension();
            $request->image->move(public_path('uploads/institute/leadership'), $image);
        }else{
            $image = !empty($leadership->image)? $leadership->image: NULL;
        }

        $data = [
            'category_id' => $instituteCategoryId,
            'position_id' => $request->position_id,
            'parent_position_id' => $request->parent_position_id,
            'image' => $image,
            'full_name' => $full_name,
            'slug' => $slug,
            'fulltext' => $fulltext,
            'reception_days' => $reception_days,
            'status' => $request->status,
        ];

        return $data;
    }
}
