<?php

namespace App\View\Composer;

use App\Models\Category;
use App\Models\Company;
use App\Models\Setting;
use App\Models\Translation;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ViewComposer
{
    public function compose(View $view)
    {
        $lang = LaravelLocalization::getCurrentLocale() ?? 'az';

        $data = [
            'lang' => $lang,
            'langIcon' => Translation::where(['code' => $lang,'status' =>1])->first(),
            'langs' => Translation::where('status',1)->get(),
            'setting' => Setting::where('title->'.$lang,'!=',NULL)->first(),
        ];
        $view->with(['data' => $data]);
    }
}
