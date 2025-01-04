<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;

class CityHelper
{
    public static function data($request)
    {
        $locales = Translation::where('status',1)->get();
        $name = []; $slug = [];

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $name[$code] = $request->input("name.".$code, '');
            $slug[$code] = Str::slug(trim($request->input("name.".$code, '')));
        }

        $data = [
            'name' => $name,
            'slug' => $slug,
            'status' => $request->status,
        ];

        return $data;
    }
}
