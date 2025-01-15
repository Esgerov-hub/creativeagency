<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EnlightenmentHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EnlightenmentRequest;
use App\Models\Enlightenment;
use App\Models\Translation;
use App\Repositories\EnlightenmentRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class EnlightenmentController extends Controller
{
    protected $enlightenmentRepository;
    protected $currentLang;

    public function __construct(EnlightenmentRepositoryImpl $enlightenmentRepository)
    {
        $this->enlightenmentRepository = $enlightenmentRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enlightenment = $this->enlightenmentRepository->getAll();
        $currentLang = $this->currentLang;
        return view('admin.enlightenment.index',compact('enlightenment','currentLang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.enlightenment.create', compact('locales','currentLang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EnlightenmentRequest $enlightenmentRequest)
    {
        try {
            $data = EnlightenmentHelper::data($enlightenmentRequest);
            $enlightenment = $this->enlightenmentRepository->create($data);
            if ($enlightenment) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $enlightenment->id,
                'subj_table' => 'enlightenment',
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
                'subj_table' => 'enlightenment',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Enlightenment $enlightenment)
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
        $enlightenment = $this->enlightenmentRepository->edit($id);
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        return view('admin.enlightenment.edit', compact('locales','enlightenment','currentLang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EnlightenmentRequest $enlightenmentRequest, $id)
    {
        try {
            $enlightenment = $this->enlightenmentRepository->edit($id);
            $data = EnlightenmentHelper::data($enlightenmentRequest,$enlightenment);
            $enlightenmentUp = $this->enlightenmentRepository->update($id,$data);
            if ($enlightenmentUp) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'enlightenment',
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
                'subj_table' => 'enlightenment',
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
            $enlightenment = $this->enlightenmentRepository->edit($id);
            if ($this->enlightenmentRepository->delete($enlightenment['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'enlightenment',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success',$messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'enlightenment',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $messages);
        }
    }
}
