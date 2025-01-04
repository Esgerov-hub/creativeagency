<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SettingsHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingsRequest;
use App\Models\Setting;
use App\Models\Translation;
use App\Repositories\SettingsRepositoryImpl;
use Illuminate\Support\Facades\Lang;

class SettingsController extends Controller
{

    protected $settingsRepository;

    public function __construct(SettingsRepositoryImpl $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function index()
    {
        $setting = Setting::first();
        $locales = Translation::where('status',1)->get();
        return view('admin.settings',compact('locales', 'setting'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingsRequest $settingsRequest)
    {
        try {
            $setting = NULL;
            $data = SettingsHelper::data($settingsRequest,$setting);
            if ($this->settingsRepository->store($data)) {
                return redirect()->back()->with('success', Lang::get('admin.add_success'));
            } else{
                return redirect()->back()->with('success', Lang::get('admin.add_error'));
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingsRequest $settingsRequest, $id)
    {
        $setting = Setting::where('id',$id)->first();
        try {
            $data = SettingsHelper::data($settingsRequest,$setting);
            if ($this->settingsRepository->update($setting['id'],$data)) {
                return redirect()->back()->with('success', Lang::get('admin.up_success'));
            } else{
                return redirect()->back()->with('success', Lang::get('admin.up_error'));
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
