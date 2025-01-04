<?php
namespace App\Helpers;
use App\Models\Translation;

class AboutHelper
{
    public static function data($request,$about,$instituteCategoryId)
    {
        $locales = Translation::where('status',1)->get();
        $title = []; $text = []; $fulltext = [];
        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $text[$code] = $request->input("text.".$code, '');
            $fulltext[$code] = $request->input("fulltext.".$code, '');
        }

        $slider_images = [];
        if ($request->hasFile('slider_image')) {
            foreach ($request->file('slider_image') as $slider_image) {
                if ($slider_image->isValid()) {
                    // Resmi kaydet
                    $filename = time() . '-' . $slider_image->getClientOriginalName();
                    $slider_image->move(public_path('uploads/institute/abouts'), $filename);
                    $slider_images[] = $filename;
                }
            }
        }
        $data = [
            'category_id' => $instituteCategoryId,
            'slider_image' => empty($request->hasFile('slider_image'))? $about->slider_image: $slider_images,
            'title' => $title,
            'text' => $text,
            'fulltext' => $fulltext
        ];

        return $data;
    }
}
