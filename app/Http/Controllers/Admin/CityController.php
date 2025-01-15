<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CityHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;
use App\Models\City;
use App\Models\Translation;
use App\Repositories\CityRepositoryImpl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CityController extends Controller
{
    protected $cityRepository;
    protected $currentLang;

    public function __construct(CityRepositoryImpl $cityRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }

    public function index()
    {
        $cities = $this->cityRepository->getAll();
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.city.index', compact('cities','locales','currentLang'));
    }

    public function create()
    {
        //
    }

    public function store(CityRequest $cityRequest)
    {
        try {
            $data = CityHelper::data($cityRequest);
            $city = $this->cityRepository->create($data);
            if ($city) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $city->id,
                'subj_table' => 'cities',
                'description' => $messages,
            ];
            saveLog($logData);
            DB::commit();
            return redirect()->back()->with('success', $messages);
        } catch (\Exception $exception) {
            DB::rollBack();
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => null,
                'subj_table' => 'cities',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function show(City $city)
    {
        //
    }

    public function edit(City $city)
    {
        //
    }

    public function update(CityRequest $cityRequest, $id)
    {
        try {
            $data = CityHelper::data($cityRequest);
            $city = $this->cityRepository->update($id,$data);
            if ($city) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'cities',
                'description' => $messages,
            ];
            saveLog($logData);
            DB::commit();
            return redirect()->back()->with('success', $messages);
        } catch (\Exception $exception) {
            DB::rollBack();
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'cities',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }



    public function destroy($id)
    {
        try {
            $city = $this->cityRepository->edit($id);
            if ($this->cityRepository->delete($city['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'cities',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success', $messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'cities',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', 'errors ' . $messages);
        }
    }
}
