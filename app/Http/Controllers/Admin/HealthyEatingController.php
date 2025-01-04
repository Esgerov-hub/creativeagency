<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HealthyEatingHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HealthyEatingRequest;
use App\Models\HealthyEating;
use App\Models\Translation;
use App\Repositories\HealthyEatingRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HealthyEatingController extends Controller
{
    protected $healthyEatingRepository;
    protected $currentLang;

    public function __construct(HealthyEatingRepositoryImpl $healthyEatingRepository)
    {
        $this->healthyEatingRepository = $healthyEatingRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $healthyEating = $this->healthyEatingRepository->getAll();
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.healthy-eating.index',compact('healthyEating','locales','currentLang'));
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
    public function store(HealthyEatingRequest $healthyEatingRequest)
    {
        try {
            $data = HealthyEatingHelper::data($healthyEatingRequest);
            $healthyEating = $this->healthyEatingRepository->create($data);
            if ($healthyEating) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $healthyEating->id,
                'subj_table' => 'healthy_eatings',
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
                'subj_table' => 'healthy_eatings',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HealthyEating $healthyEating)
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
    public function update(HealthyEatingRequest $healthyEatingRequest, $id)
    {
        try {
            $healthyEating = $this->healthyEatingRepository->edit($id);
            $data = HealthyEatingHelper::data($healthyEatingRequest,$healthyEating);
            $healthyEating = $this->healthyEatingRepository->update($id,$data);
            if ($healthyEating) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'healthy_eatings',
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
                'subj_table' => 'healthy_eatings',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $healthyEating = $this->healthyEatingRepository->edit($id);
            if ($this->healthyEatingRepository->delete($healthyEating['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'healthy_eatings',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success', $messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'healthy_eatings',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', 'errors ' . $messages);
        }
    }
}
