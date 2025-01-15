<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CareerHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Career;
use App\Models\CareerContact;
use App\Models\Translation;
use App\Repositories\CareerRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CareerController extends Controller
{
    protected $careerRepository;
    protected $currentLang;

    public function __construct(CareerRepositoryImpl $careerRepository)
    {
        $this->careerRepository = $careerRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }

    public function index()
    {
        $career = $this->careerRepository->getAll();
        $currentLang = $this->currentLang;
        return view('admin.career.index',compact('career','currentLang'));
    }

    public function create()
    {
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.career.create', compact('locales','currentLang'));
    }

    public function store(CategoryRequest $categoryRequest)
    {
        try {
            $data = CareerHelper::data($categoryRequest);
            $save = $this->careerRepository->create($data);
            if ($save) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $save->id,
                'subj_table' => 'careers',
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
                'subj_table' => 'careers',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function show(Career $career)
    {
        //
    }

    public function edit($id)
    {
        $career = $this->careerRepository->edit($id);
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.career.edit', compact('locales','career','currentLang'));
    }

    public function update(CategoryRequest $categoryRequest, $id)
    {
        try {
            $data = CareerHelper::data($categoryRequest);
            $up = $this->careerRepository->update($id,$data);
            if ($up) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'careers',
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
                'subj_table' => 'careers',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $career = $this->careerRepository->edit($id);
            if ($this->careerRepository->delete($career['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'careers',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success',$messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'careers',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $messages);
        }
    }

    public function contact(){
        $currentLang = $this->currentLang;
        $careerContact = CareerContact::where(['is_deleted' => 0, 'is_vacancy' => 1])->orderBy('id','DESC')->get();
        return view('admin.career.contact',compact('currentLang','careerContact'));
    }

    public function volunteer(){
        $currentLang = $this->currentLang;
        $careerContact = CareerContact::where(['is_deleted' => 0, 'is_vacancy' => 0])->orderBy('id','DESC')->get();
        return view('admin.career.volunteer',compact('currentLang','careerContact'));
    }

    public function contactDestroy($id){
        try {
            $careerContact = CareerContact::where(['id'=> $id, 'is_deleted' => 0])->orderBy('id','DESC')->first();
            if (!empty($careerContact)) {
                CareerContact::where(['id'=> $id, 'is_deleted' => 0])->orderBy('id','DESC')->delete();
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'career_contacts',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success',$messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'career_contacts',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $messages);
        }
    }


}
