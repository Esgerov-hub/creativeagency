<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UsefulHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsefulRequest;
use App\Models\Translation;
use App\Models\Useful;
use App\Models\UsefulCategory;
use App\Repositories\UsefulRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UsefulController extends Controller
{
    protected $usefulRepository;
    protected $currentLang;

    public function __construct(UsefulRepositoryImpl $usefulRepository)
    {
        $this->usefulRepository = $usefulRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $useful = $this->usefulRepository->getAll();
        $currentLang = $this->currentLang;
        return view('admin.useful.index',compact('useful','currentLang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locales = Translation::where('status',1)->get();
        $mainUsefulCategories = UsefulCategory::whereNull('parent_id')->orderBy('id','DESC')->get();
        $currentLang = $this->currentLang;
        return view('admin.useful.create', compact('locales','mainUsefulCategories','currentLang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsefulRequest $usefulRequest)
    {
        try {
            $data = UsefulHelper::data($usefulRequest);
            $useful = $this->usefulRepository->create($data);
            if ($useful) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $useful->id,
                'subj_table' => 'useful',
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
                'subj_table' => 'useful',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Useful $useful)
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
        $useful = $this->usefulRepository->edit($id);
        $locales = Translation::where('status',1)->get();
        $mainUsefulCategories = UsefulCategory::whereNull('parent_id')->orderBy('id','DESC')->get();
        $currentLang = $this->currentLang;
        return view('admin.useful.edit', compact('locales','useful','mainUsefulCategories','currentLang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsefulRequest $usefulRequest, $id)
    {
        try {
            $useful = Useful::where('id',$id)->first();
            $data = UsefulHelper::data($usefulRequest,$useful);
            $usefulUp = $this->usefulRepository->update($id,$data);
            if ($usefulUp) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'useful',
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
                'subj_table' => 'useful',
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
            $useful = Useful::where('id',$id)->first();
            if ($this->usefulRepository->delete($useful['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'useful',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success',$messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'useful',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $messages);
        }
    }
}
