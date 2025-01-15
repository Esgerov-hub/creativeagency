<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TariffCategoryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TariffCategoryRequest;
use App\Models\Tariff;
use App\Models\TariffCategory;
use App\Models\Translation;
use App\Repositories\TariffCategoryRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TariffCategoryController extends Controller
{
    protected $tariffCategoryRepository;
    protected $currentLang;

    public function __construct(TariffCategoryRepositoryImpl $tariffCategoryRepository)
    {
        $this->tariffCategoryRepository = $tariffCategoryRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }

    public function index()
    {
        $categories = $this->tariffCategoryRepository->getAll();
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.tariff-category.index', compact('categories','locales','currentLang'));
    }

    public function create()
    {
        //
    }

    public function store(TariffCategoryRequest $tariffCategoryRequest)
    {
        try {
            $data = TariffCategoryHelper::data($tariffCategoryRequest);
            $category = $this->tariffCategoryRepository->create($data);
            if ($category) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $category->id,
                'subj_table' => 'tariff_categories',
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
                'subj_table' => 'tariff_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function show(TariffCategory $tariffCategory)
    {
        //
    }

    public function edit(TariffCategory $tariffCategory)
    {
        //
    }

    public function update(TariffCategoryRequest $tariffCategoryRequest, $id)
    {
        try {
            $category = $this->tariffCategoryRepository->edit($id);
            $data = TariffCategoryHelper::data($tariffCategoryRequest,$category);
            $category = $this->tariffCategoryRepository->update($id,$data);
            if ($category) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'tariff_categories',
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
                'subj_table' => 'tariff_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $category = $this->tariffCategoryRepository->edit($id);
            $deleteData = Tariff::where('category_id',$id)->delete();
            if ($this->tariffCategoryRepository->delete($category['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'tariff_categories',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success', $messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'tariff_categories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', 'errors ' . $messages);
        }
    }
}
