<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UsefulCategoryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsefulCategoryRequest;
use App\Models\Translation;
use App\Models\Useful;
use App\Models\UsefulCategory;
use App\Repositories\UsefulCategoryRepositoryImpl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UsefulCategoryController extends Controller
{
    protected $usefulCategoryRepository;
    protected $currentLang;

    public function __construct(UsefulCategoryRepositoryImpl $usefulCategoryRepository)
    {
        $this->usefulCategoryRepository = $usefulCategoryRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }

    public function index()
    {
        $usefulCategories = $this->usefulCategoryRepository->getAll();
        $mainUsefulCategories = UsefulCategory::whereNull('parent_id')->where('status',1)->get();
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.useful-categories.index', compact('usefulCategories','mainUsefulCategories','locales','currentLang'));
    }

    public function create()
    {
        //
    }

    public function store(UsefulCategoryRequest $usefulCategoryRequest)
    {
        try {
            $data = UsefulCategoryHelper::data($usefulCategoryRequest);
            $usefulCategory = $this->usefulCategoryRepository->create($data);
            if ($usefulCategory) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $usefulCategory->id,
                'subj_table' => 'useful_categories',
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
                'subj_table' => 'useful_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function show(UsefulCategory $usefulCategory)
    {
        //
    }

    public function edit(UsefulCategory $usefulCategory)
    {
        //
    }

    public function update(UsefulCategoryRequest $usefulCategoryRequest, $id)
    {
        try {
            $data = UsefulCategoryHelper::data($usefulCategoryRequest);
            $usefulCategory = $this->usefulCategoryRepository->update($id,$data);
            if ($usefulCategory) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'useful_categories',
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
                'subj_table' => 'useful_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $usefulCategory = $this->usefulCategoryRepository->edit($id);
            $useful = Useful::where('category_id',$id)->delete();
            if ($this->usefulCategoryRepository->delete($usefulCategory['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'useful_categories',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success', $messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'useful_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', 'errors ' . $messages);
        }

    }

    public function getParentCategories(Request $request)
    {
        $parentId = $request->input('category_id');
        if (!$parentId) {
            return response()->json(['success' => false, 'message' => 'Invalid parent ID']);
        }

        // Alt kateqoriyaları gətir
        $subCategories = UsefulCategory::where('parent_id', $parentId)->whereNotNull('parent_id')->whereNull('sub_parent_id')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category['title'][$this->currentLang] ?? null,
            ];
        });

        return response()->json(['success' => true, 'parentCategories' => $subCategories]);
    }

    public function getSubCategories(Request $request)
    {
        $sub_parent_id = $request->input('parent_id');
        if (!$sub_parent_id) {
            return response()->json(['success' => false, 'message' => 'Invalid parent ID']);
        }

        // Alt kateqoriyaları gətir
        $subCategories = UsefulCategory::where('sub_parent_id', $sub_parent_id)->whereNotNull('parent_id')->whereNotNull('sub_parent_id')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category['title'][$this->currentLang] ?? null,
            ];
        });

        return response()->json(['success' => true, 'subParentCategories' => $subCategories]);
    }

}
