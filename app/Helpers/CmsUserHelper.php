<?php

namespace App\Helpers;

use App\Models\Translation;
use Illuminate\Support\Facades\Hash;

class CmsUserHelper
{
    public static function data($request,$user)
    {
        if($request->hasFile('image')){
            $image_name = time().'.'.$request->image->extension();
            $image_url = $request->image->move(public_path('uploads/categories'), $image_name);
            $image = $image_url->getFilename();
        }else{
            $image_name = !empty($user['image'])? $user['image']: NULL;
        }

        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'father_name' => $request->father_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $image_name,
            'type' => $request->role,
            'password' => !empty($request->password)? Hash::make($request->password) : $user['password'],
            'status' => $request->status,
        ];

        return $data;
    }
}
