<?php

namespace App\Helpers;

use App\Models\Translation;

class SettingsHelper
{
    public static function data($request,$setting)
    {
        $locales = Translation::where('status',1)->get();
        $title = []; $text = []; $address = [];

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $text[$code] = $request->input("text.".$code, '');
            $address[$code] = $request->input("address.".$code, '');
        }

        if($request->hasFile('header_logo')){
            $header_logo = time().'.head.'.$request->header_logo->extension();
            $request->header_logo->move(public_path('uploads/settings'), $header_logo);
        }else{
            $header_logo = !empty($setting->header_logo)? $setting->header_logo: NULL;
        }

        if($request->hasFile('footer_logo')){
            $footer_logo = time().'.foot.'.$request->footer_logo->extension();
            $request->footer_logo->move(public_path('uploads/settings'), $footer_logo);
        }else{
            $footer_logo = !empty($setting->footer_logo)? $setting->footer_logo: NULL;
        }

        if($request->hasFile('favicon')){
            $favicon = time().'.favicon.'.$request->favicon->extension();
            $request->favicon->move(public_path('uploads/settings'), $favicon);
        }else{
            $favicon = !empty($setting->favicon)? $setting->favicon: NULL;
        }

        $data = [
            'title' => $title,
            'text' => $text,
            'address' => $address,
            'header_logo' => $header_logo,
            'footer_logo' => $footer_logo,
            'favicon' => $favicon,
            'phone' => $request->phone,
            'email' => $request->email,
            'instagram' => $request->instagram,
            'telegram' => $request->telegram,
            'whatsapp' => $request->whatsapp,
            'youtube' => $request->youtube,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'accepted_samples' => $request->accepted_samples ?? 0,
            'laboratory_examinations' => $request->laboratory_examinations ?? 0,
            'animal_identification' => $request->animal_identification ?? 0,
            'trainees' => $request->trainees ?? 0
        ];
//        dd($data);
        return $data;
    }
}
