<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\InstituteCategoryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InstituteCategoryRequest;
use App\Models\About;
use App\Models\Accreditation;
use App\Models\Charter;
use App\Models\InstituteCategory;
use App\Models\LeaderShip;
use App\Models\Position;
use App\Models\Structure;
use App\Models\Translation;
use App\Repositories\InstituteCategoryRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class InstituteCategoryController extends Controller
{
    protected $instituteCategoryRepository;
    protected $currentLang;

    public function __construct(InstituteCategoryRepositoryImpl $instituteCategoryRepository)
    {
        $this->instituteCategoryRepository = $instituteCategoryRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }

    public function index()
    {
        $instituteCategory = $this->instituteCategoryRepository->getAll();
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.institute-categories.index', compact('instituteCategory','locales','currentLang'));
    }

    public function create()
    {
        //
    }

    public function store(InstituteCategoryRequest $instituteCategoryRequest)
    {
        try {
            $data = InstituteCategoryHelper::data($instituteCategoryRequest);
            $instituteCategory = $this->instituteCategoryRepository->create($data);
            if ($instituteCategory) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $instituteCategory->id,
                'subj_table' => 'institute_categories',
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
                'subj_table' => 'institute_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function show(InstituteCategory $instituteCategory)
    {
        //
    }

    public function edit(InstituteCategory $instituteCategory)
    {
        //
    }

    public function update(InstituteCategoryRequest $instituteCategoryRequest, $id)
    {
        try {
            $data = InstituteCategoryHelper::data($instituteCategoryRequest);
            $instituteCategory = $this->instituteCategoryRepository->update($id,$data);
            if ($instituteCategory) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'institute_categories',
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
                'subj_table' => 'institute_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $instituteCategory = $this->instituteCategoryRepository->edit($id);
            if ($instituteCategory['page_type'] == 'slide_content'){
                $institutePage = About::where(['category_id' => $instituteCategory['id']])->delete();
            }elseif ($instituteCategory['page_type'] == 'file_content'){
                $institutePage = Charter::where(['category_id' => $instituteCategory['id']])->delete();
            }elseif ($instituteCategory['page_type'] == 'image_content'){
                $institutePage = LeaderShip::where('category_id',$instituteCategory['id'])->delete();
            }elseif ($instituteCategory['page_type'] == 'content'){
                $institutePage = Structure::where('category_id',$instituteCategory['id'])->delete();
            }elseif ($instituteCategory['page_type'] == 'photo'){
                $institutePage = Accreditation::where('category_id',$instituteCategory['id'])->delete();
            }
            if ($this->instituteCategoryRepository->delete($instituteCategory['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'institute_categories',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success', $messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'institute_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', 'errors ' . $messages);
        }
    }
}
