<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LaboratoryCategoryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LaboratoryCategoryRequest;
use App\Models\Laboratory;
use App\Models\LaboratoryCategory;
use App\Models\Translation;
use App\Repositories\LaboratoryCategoryRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LaboratoryCategoryController extends Controller
{
    protected $laboratoryCategoryRepository;
    protected $currentLang;

    public function __construct(LaboratoryCategoryRepositoryImpl $laboratoryCategoryRepository)
    {
        $this->laboratoryCategoryRepository = $laboratoryCategoryRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }

    public function index()
    {
        $categories = $this->laboratoryCategoryRepository->getAll();
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.laboratory-category.index', compact('categories','locales','currentLang'));
    }

    public function create()
    {
        //
    }

    public function store(LaboratoryCategoryRequest $laboratoryCategoryRequest)
    {
        try {
            $data = LaboratoryCategoryHelper::data($laboratoryCategoryRequest);
            $category = $this->laboratoryCategoryRepository->create($data);
            if ($category) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $category->id,
                'subj_table' => 'laboratory_categories',
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
                'subj_table' => 'laboratory_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function show(LaboratoryCategory $laboratoryCategory)
    {
        //
    }

    public function edit(LaboratoryCategory $laboratoryCategory)
    {
        //
    }

    public function update(LaboratoryCategoryRequest $laboratoryCategoryRequest, $id)
    {
        try {
            $data = LaboratoryCategoryHelper::data($laboratoryCategoryRequest);
            $category = $this->laboratoryCategoryRepository->update($id,$data);
            if ($category) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'laboratory_categories',
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
                'subj_table' => 'laboratory_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $category = $this->laboratoryCategoryRepository->edit($id);
            $laboratory = Laboratory::where('category_id',$id)->delete();
            if ($this->laboratoryCategoryRepository->delete($category['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'laboratory_categories',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success', $messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'laboratory_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', 'errors ' . $messages);
        }
    }
}
