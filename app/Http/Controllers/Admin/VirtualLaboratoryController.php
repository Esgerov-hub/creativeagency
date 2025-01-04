<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\VirtualLaboratoryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VirtualLaboratoryRequest;
use App\Models\Translation;
use App\Models\VirtualLaboratory;
use App\Repositories\VirtualLaboratoryRepositoryImpl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class VirtualLaboratoryController extends Controller
{
    protected $virtualLaboratoryRepository;
    protected $currentLang;

    public function __construct(VirtualLaboratoryRepositoryImpl $virtualLaboratoryRepository)
    {
        $this->virtualLaboratoryRepository = $virtualLaboratoryRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $virtualLaboratory = $this->virtualLaboratoryRepository->getAll();
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.virtual-laboratory.index',compact('virtualLaboratory','locales','currentLang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VirtualLaboratoryRequest $virtualLaboratoryRequest)
    {
        try {
            $data = VirtualLaboratoryHelper::data($virtualLaboratoryRequest);
            $virtualLaboratory = $this->virtualLaboratoryRepository->create($data);
            if ($virtualLaboratory) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $virtualLaboratory->id,
                'subj_table' => 'virtual_laboratories',
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
                'subj_table' => 'virtual_laboratories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VirtualLaboratory $virtualLaboratory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VirtualLaboratoryRequest $virtualLaboratoryRequest, $id)
    {
        try {
            $data = VirtualLaboratoryHelper::data($virtualLaboratoryRequest);
            $virtualLaboratory = $this->virtualLaboratoryRepository->update($id,$data);
            if ($virtualLaboratory) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'virtual_laboratories',
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
                'subj_table' => 'virtual_laboratories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $virtualLaboratory = $this->virtualLaboratoryRepository->edit($id);
            if ($this->virtualLaboratoryRepository->delete($virtualLaboratory['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'virtual_laboratories',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success', $messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'virtual_laboratories',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', 'errors ' . $messages);
        }
    }
}
