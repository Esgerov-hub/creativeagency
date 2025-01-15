<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Str;

class UsefulHelper
{
    public static function data($request,$useful = null)
    {

        $locales = Translation::where('status',1)->get();
        $title = []; $text = []; $fulltext = []; $slug = [];

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $slug[$code] = Str::slug(trim($request->input("title.".$code, '')));
            $text[$code] = $request->input("text.".$code, '');
            $fulltext[$code] = $request->input("fulltext.".$code, '');
        }

        if($request->hasFile('image')){
            $image = time().$request->image->extension();
            $request->image->move(public_path('uploads/useful/image'), $image);
        }else{
            $image = !empty($useful->image)? $useful->image: NULL;
        }

        if($request->hasFile('file')){
            $file = time().$request->file->extension();
            $request->file->move(public_path('uploads/useful/file'), $file);
        }else{
            $file = !empty($useful->file)? $useful->file: NULL;
        }
        $slider_images = [];
        if ($request->hasFile('slider_image')) {
            foreach ($request->file('slider_image') as $slider_image) {
                if ($slider_image->isValid()) {
                    // Resmi kaydet
                    $filename = time() . '-' . $slider_image->getClientOriginalName();
                    $slider_image->move(public_path('uploads/useful/slider_image'), $filename);
                    $slider_images[] = $filename;
                }
            }
        }
        $data = [
            'category_id' => $request->category_id,
            'parent_category_id' => $request->parent_id ?? null,
            'sub_parent_category_id' => $request->sub_parent_id ?? null,
            'image' => $image,
            'file' => $file,
            'slider_image' => !empty($useful->slider_image)? $useful->slider_image: $slider_images,
            'title' => $title,
            'slug' => $slug,
            'text' => $text,
            'fulltext' => $fulltext,
            'status' => $request->status,
            'datetime' => date('Y-m-d H:i:s',strtotime($request->datetime)),
        ];

        return $data;
    }
}
