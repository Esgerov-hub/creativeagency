<?php
namespace App\View\Components\Site;
use App\Models\Category;
use App\Models\InstituteCategory;
use App\Models\LaboratoryCategory;
use App\Models\Service;
use App\Models\Setting;
use App\Models\UsefulCategory;
use Illuminate\View\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Footer extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $currentLang = LaravelLocalization::getCurrentLocale();
        $setting = Setting::first();
        $services = Service::where('status',1)->get();
        return view('components.site.footer',compact('currentLang','setting','services'));
    }
}
