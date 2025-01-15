<?php

namespace App\View\Components\Admin;

//use App\Models\Role;
use App\Models\Category;
use App\Models\InstituteCategory;
use Illuminate\View\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Main extends Component
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
        $categories = Category::orderBy('id','DESC')->get();
        $instituteCategory = InstituteCategory::all();
        return view('components.admin.left-sidebar',compact('categories','currentLang','instituteCategory'));
    }
}
