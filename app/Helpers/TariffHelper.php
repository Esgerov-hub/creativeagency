<?php
namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;

class TariffHelper
{
    public static function data($request,$data = null)
    {
        $locales = Translation::where('status',1)->get();
        $title = []; $slug = []; $unit_of_measure = []; $service_charge = [];

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $unit_of_measure[$code] = $request->input("unit_of_measure.".$code, '');
            $service_charge[$code] = $request->input("service_charge.".$code, '');
            $slug[$code] = Str::slug(trim($request->input("title.".$code, '')));
        }

        $data = [
            'category_id' => $request->category_id,
            'parent_id' => !empty($request->parent_id)? $request->parent_id: null,
            'sub_parent_id' => !empty($request->parent_id)? $request->sub_parent_id: null,
            'title' => $title,
            'slug' => $slug,
            'unit_of_measure' => $unit_of_measure,
            'service_charge' => $service_charge,
            'status' => $request->status,
        ];

        return $data;
    }
}
