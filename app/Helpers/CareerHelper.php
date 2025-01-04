<?php
namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;
class CareerHelper
{
    public static function data($request)
    {
        $locales = Translation::where('status',1)->get();
        $title = []; $slug = []; $full_text = [];
        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $slug[$code] = Str::slug(trim($request->input("title.".$code, '')));
            $full_text[$code] = $request->input("full_text.".$code, '');
        }

        $data = [
            'title' => $title,
            'slug' => $slug,
            'full_text' => $full_text,
            'datetime' => date('Y-m-d H:i:s',strtotime($request->datetime)),
            'status' => $request->status,
        ];

        return $data;
    }
}
