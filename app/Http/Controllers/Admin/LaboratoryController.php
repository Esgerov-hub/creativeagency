<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LaboratoryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LaboratoryRequest;
use App\Models\City;
use App\Models\Laboratory;
use App\Models\LaboratoryCategory;
use App\Models\Translation;
use App\Repositories\LaboratoryRepositoryImpl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LaboratoryController extends Controller
{
    protected $laboratoryRepository;
    protected $currentLang;

    public function __construct(LaboratoryRepositoryImpl $laboratoryRepository)
    {
        $this->laboratoryRepository = $laboratoryRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laboratories = $this->laboratoryRepository->getAll();
        $currentLang = $this->currentLang;
        return view('admin.laboratory.index',compact('laboratories','currentLang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locales = Translation::where('status',1)->get();
        $cities = City::where('status',1)->orderBy('id','DESC')->get();
        $categories = LaboratoryCategory::where('status',1)->orderBy('id','DESC')->get();
        $currentLang = $this->currentLang;
        return view('admin.laboratory.create', compact('locales','cities','categories','currentLang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LaboratoryRequest $laboratoryRequest)
    {
        try {
            $data = LaboratoryHelper::data($laboratoryRequest);
            $laboratory = $this->laboratoryRepository->create($data);
            if ($laboratory) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $laboratory->id,
                'subj_table' => 'laboratories',
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
                'subj_table' => 'laboratories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Laboratory $laboratory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $laboratory = $this->laboratoryRepository->edit($id);
        $locales = Translation::where('status',1)->get();
        $cities = City::where('status',1)->orderBy('id','DESC')->get();
        $categories = LaboratoryCategory::where('status',1)->orderBy('id','DESC')->get();
        $currentLang = $this->currentLang;
        return view('admin.laboratory.edit', compact('locales','laboratory','cities','categories','currentLang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LaboratoryRequest $laboratoryRequest, $id)
    {
        try {
            $laboratory = $this->laboratoryRepository->edit($id);
            $data = LaboratoryHelper::data($laboratoryRequest,$laboratory);
            $up = $this->laboratoryRepository->update($id,$data);
            if ($up) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'laboratories',
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
                'subj_table' => 'laboratories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $laboratory = $this->laboratoryRepository->edit($id);
            if ($this->laboratoryRepository->delete($laboratory['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'laboratories',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success',$messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'laboratories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $messages);
        }
    }
}
