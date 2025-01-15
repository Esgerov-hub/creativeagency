<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ServiceHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use App\Models\Translation;
use App\Repositories\ServiceRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ServiceController extends Controller
{
    protected $serviceRepository;
    protected $currentLang;

    public function __construct(ServiceRepositoryImpl $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }

    public function index()
    {
        $services = $this->serviceRepository->getAll();
        $currentLang = $this->currentLang;
        return view('admin.services.index',compact('services','currentLang'));
    }

    public function orderBy(Request $request)
    {
        $sortedIDs = $request->sortedIDs;

        foreach ($sortedIDs as $order => $id) {
            Service::where('id', $id)->update(['order_by' => $order + 1]);
        }

        return response()->json(['status' => 'success']);
    }

    public function create()
    {
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.services.create', compact('locales','currentLang'));
    }

    public function store(ServiceRequest $serviceRequest)
    {
        try {
            $data = ServiceHelper::data($serviceRequest);
            $service = $this->serviceRepository->create($data);
            if ($service) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $service->id,
                'subj_table' => 'services',
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
                'subj_table' => 'services',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function show(Service $service)
    {
        //
    }

    public function edit($id)
    {
        $service = $this->serviceRepository->edit($id);
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.services.edit', compact('locales','service','currentLang'));
    }

    public function update(ServiceRequest $serviceRequest, $id)
    {
        try {
            $service = Service::where('id',$id)->first();
            $data = ServiceHelper::data($serviceRequest,$service);
            $serviceUp = $this->serviceRepository->update($id,$data);
            if ($serviceUp) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'services',
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
                'subj_table' => 'services',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::where('id',$id)->first();
            if ($this->serviceRepository->delete($service['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'services',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success',$messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'services',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $messages);
        }
    }
}
