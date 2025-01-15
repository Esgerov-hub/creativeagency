<?php

namespace App\Helpers;

class TranslationHelper
{
    public static function data($request)
    {
        $name = $request->input("name", '');
        $code = $request->input("code", '');

        if($request->hasFile('image')){
            $image_name = time().'.'.$request->image->extension();
            $image_url = $request->image->move(public_path('uploads/translations'), $image_name);
            $image = $image_url->getFilename();
        }else{
            $image_name = NULL;
        }

        $data = [
            'name' => $name,
            'code' => $code,
            'icon' => $image_name,
            'status' => $request->status,
        ];
        return $data;
    }
}
