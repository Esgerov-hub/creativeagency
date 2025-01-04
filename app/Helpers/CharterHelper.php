<?php
namespace App\Helpers;
use App\Models\Translation;

class CharterHelper
{
    public static function data($request,$charter,$instituteCategoryId)
    {
        $locales = Translation::where('status',1)->get();
        $title = []; $text = []; $fulltext = [];
        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $text[$code] = $request->input("text.".$code, '');
            $fulltext[$code] = $request->input("fulltext.".$code, '');
        }

        if($request->hasFile('file')){
            $file = time().$request->file->extension();
            $request->file->move(public_path('uploads/institute/charter'), $file);
        }else{
            $file = !empty($charter->file)? $charter->file: NULL;
        }
        $data = [
            'category_id' => $instituteCategoryId,
            'file' => $file,
            'title' => $title,
            'text' => $text,
            'fulltext' => $fulltext
        ];

        return $data;
    }
}
