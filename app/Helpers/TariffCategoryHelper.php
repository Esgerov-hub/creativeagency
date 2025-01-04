<?php
namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;

class TariffCategoryHelper
{
    public static function data($request,$data = null)
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
            $request->image->move(public_path('uploads/tariff-category'), $image);
        }else{
            $image = !empty($data->image)? $data->image: NULL;
        }
        $data = [
            'title' => $title,
            'slug' => $slug,
            'image' => $image,
            'status' => $request->status,
        ];

        return $data;
    }
}
