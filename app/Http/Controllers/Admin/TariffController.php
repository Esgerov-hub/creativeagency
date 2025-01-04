<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TariffHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TariffRequest;
use App\Models\Tariff;
use App\Models\TariffCategory;
use App\Models\Translation;
use App\Repositories\TariffRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TariffController extends Controller
{
    protected $tariffRepository;
    protected $currentLang;

    public function __construct(TariffRepositoryImpl $tariffRepository)
    {
        $this->tariffRepository = $tariffRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }

    public function index()
    {
        $tariffs = $this->tariffRepository->getAll();
        $mainTariff = Tariff::whereNull('parent_id')->where('status',1)->get();
        $categories = TariffCategory::where('status',1)->get();
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
//        dd($tariffs);
        return view('admin.tariffs.index', compact('tariffs','mainTariff','locales','currentLang','categories'));
    }

    public function create()
    {
        //
    }

    public function store(TariffRequest $tariffRequest)
    {
        try {
            $data = TariffHelper::data($tariffRequest);
            $tariff = $this->tariffRepository->create($data);
            if ($tariff) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $tariff->id,
                'subj_table' => 'tariffs',
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
                'subj_table' => 'tariffs',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function show(Tariff $tariff)
    {
        //
    }

    public function edit(Tariff $tariff)
    {
        //
    }

    public function update(TariffRequest $tariffRequest, $id)
    {
        try {
            $data = TariffHelper::data($tariffRequest);
            $tariff = $this->tariffRepository->update($id,$data);
            if ($tariff) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'tariffs',
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
                'subj_table' => 'tariffs',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $usefulCategory = $this->tariffRepository->edit($id);
            if ($this->tariffRepository->delete($usefulCategory['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'tariffs',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success', $messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'tariffs',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', 'errors ' . $messages);
        }

    }

    public function getParentTariff(Request $request)
    {
        $parentId = $request->input('tariff_id');
        if (!$parentId) {
            return response()->json(['success' => false, 'message' => 'Invalid parent ID']);
        }

        // Alt kateqoriyaları gətir
        $parentTariff = Tariff::where('parent_id', $parentId)->whereNotNull('parent_id')->get()->map(function ($tariff) {
            return [
                'id' => $tariff->id,
                'title' => $tariff['title'][$this->currentLang] ?? null,
            ];
        });

        return response()->json(['success' => true, 'parentTariff' => $parentTariff]);
    }
    public function getSubTariff(Request $request)
    {
        $sub_parent_id = $request->input('parent_id');
        if (!$sub_parent_id) {
            return response()->json(['success' => false, 'message' => 'Invalid parent ID']);
        }

        // Alt kateqoriyaları gətir
        $subTariff = Tariff::where('sub_parent_id', $sub_parent_id)->whereNotNull('parent_id')->whereNotNull('sub_parent_id')->get()->map(function ($tariff) {
            return [
                'id' => $tariff->id,
                'title' => $tariff['title'][$this->currentLang] ?? null,
            ];
        });

        return response()->json(['success' => true, 'subTariff' => $subTariff]);
    }
}
