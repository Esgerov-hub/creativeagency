<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;

class PositionHelper
{
    public static function data($request)
    {
        $locales = Translation::where('status',1)->get();
        $title = [];

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
        }

        $data = [
            'title' => $title,
            'parent_id' => $request->parent_id ?? null,
            'status' => $request->status,
        ];
        return $data;
    }
}
