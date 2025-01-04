<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AboutHelper;
use App\Helpers\AccreditationHelper;
use App\Helpers\CharterHelper;
use App\Helpers\LeaderShipHelper;
use App\Helpers\StructureHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InstituteRequest;
use App\Models\About;
use App\Models\Accreditation;
use App\Models\Charter;
use App\Models\InstituteCategory;
use App\Models\Position;
use App\Models\Structure;
use App\Models\Translation;
use App\Repositories\AboutRepositoryImpl;
use App\Repositories\AccreditationRepositoryImpl;
use App\Repositories\CharterRepositoryImpl;
use App\Repositories\LeaderShipRepositoryImpl;
use App\Repositories\StructureRepositoryImpl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class InstituteController extends Controller
{
    protected $aboutRepository;
    protected $charterRepository;
    protected $leaderShipRepository;
    protected $structureRepository;
    protected $accreditationRepository;
    protected $currentLang;

    public function __construct(AboutRepositoryImpl $aboutRepository, CharterRepositoryImpl $charterRepository, LeaderShipRepositoryImpl $leaderShipRepository, StructureRepositoryImpl $structureRepository, AccreditationRepositoryImpl $accreditationRepository)
    {
        $this->aboutRepository = $aboutRepository;
        $this->charterRepository = $charterRepository;
        $this->leaderShipRepository = $leaderShipRepository;
        $this->structureRepository = $structureRepository;
        $this->accreditationRepository = $accreditationRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }

    public function index($slug){
        $instituteCategory = InstituteCategory::where(['slug->'.$this->currentLang => $slug,'status' => 1])->first();
        if (empty($instituteCategory)){
            return redirect(route('admin.index'));
        }
        $currentLang = $this->currentLang;
        $locales = Translation::where('status',1)->get();
        $institutePage = null;
        if ($instituteCategory['page_type'] == 'slide_content'){
            $institutePage = About::where(['category_id' => $instituteCategory['id']])->first();
        }elseif ($instituteCategory['page_type'] == 'file_content'){
            $institutePage = Charter::where(['category_id' => $instituteCategory['id']])->first();
        }elseif ($instituteCategory['page_type'] == 'image_content'){
            $institutePage = Position::where(['status' => 1])->whereNull('parent_id')->with('leaderShip')->
            whereHas('leaderShip', function ($query) use ($instituteCategory) {
                $query->where('category_id', $instituteCategory['id']);
            })->get();
        }elseif ($instituteCategory['page_type'] == 'content'){
            $institutePage = $this->structureRepository->getAll();
        }elseif ($instituteCategory['page_type'] == 'photo'){
            $institutePage = $this->accreditationRepository->getAll();
        }
        return view('admin.institute.index',compact('instituteCategory','currentLang','locales','institutePage'));
    }

    public function create($slug){
        $instituteCategory = InstituteCategory::where(['slug->'.$this->currentLang => $slug,'status' => 1])->first();
        if (empty($instituteCategory)){
            return redirect(route('admin.index'));
        }
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        $positions = null;
        if ($instituteCategory['page_type'] == 'image_content'){
            $positions = Position::where(['status' => 1])->whereNull('parent_id')->get();
        }elseif ($instituteCategory['page_type'] == 'content'){
            $positions = Position::where(['status' => 1])->whereNull('parent_id')->get();
        }
        return view('admin.institute.create',compact('instituteCategory','positions','locales','currentLang'));
    }


    public function store(InstituteRequest $instituteRequest)
    {
        try {
            $instituteCategory = InstituteCategory::where(['slug->'.$this->currentLang => $instituteRequest['category_slug'],'status' => 1])->first();
            $institutePage = null;
            $table = null;
            $dataSave = false;
            if ($instituteCategory['page_type'] == 'slide_content') {

                $data = AboutHelper::data($instituteRequest,$institutePage,$instituteCategory['id']);
                $dataSave = $this->aboutRepository->create($data);
                $table = 'abouts';
            }elseif ($instituteCategory['page_type'] == 'file_content') {
                $data = CharterHelper::data($instituteRequest,$institutePage,$instituteCategory['id']);
                $dataSave = $this->charterRepository->create($data);
                $table = 'charters';
            }elseif ($instituteCategory['page_type'] == 'image_content') {
                $data = LeaderShipHelper::data($instituteRequest,$institutePage,$instituteCategory['id']);
                $dataSave = $this->leaderShipRepository->create($data);
                $table = 'leaderships';
            }elseif ($instituteCategory['page_type'] == 'content') {
                $data = StructureHelper::data($instituteRequest,$institutePage,$instituteCategory['id']);
                $dataSave = $this->structureRepository->create($data);
                $table = 'structures';
            }elseif ($instituteCategory['page_type'] == 'photo') {
                $validator = Validator::make($instituteRequest->all(), [
                    'title.*' => 'required|string|max:255',
                    'image' => 'required|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=599,max_height=441',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('errors','errors '. $validator->errors());
                }

                $data = AccreditationHelper::data($instituteRequest,$institutePage,$instituteCategory['id']);
                $dataSave = $this->accreditationRepository->create($data);
                $table = 'accreditations';
            }
            $messages = !empty($dataSave)? Lang::get('admin.add_success'): Lang::get('admin.add_error');

            $logData = [
                'subj_id' => $dataSave->id,
                'subj_table' => $table,
                'description' => $messages,
            ];
            saveLog($logData);
            DB::commit();
            return redirect()->back()->with('success', $messages);
        } catch (\Exception $exception) {
            DB::rollBack();
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => empty($institutePage['id'])? null: $institutePage['id'],
                'subj_table' => $table,
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function edit($id,$slug){
        $instituteCategory = InstituteCategory::where(['slug->'.$this->currentLang => $slug,'status' => 1])->first();
        if (empty($instituteCategory)){
            return redirect(route('admin.index'));
        }
        $locales = Translation::where('status',1)->get();
        $currentLang = $this->currentLang;
        $positions = null;
        if ($instituteCategory['page_type'] == 'image_content'){
            $institutePage = $this->leaderShipRepository->edit($id);
            $positions = Position::where(['status'=>1])->whereNull('parent_id')->get();
        }elseif ($instituteCategory['page_type'] == 'content'){
            $institutePage = $this->structureRepository->edit($id);
            $positions = Position::where('status',1)->whereNull('parent_id')->get();
        }elseif ($instituteCategory['page_type'] == 'photo'){
            $institutePage = $this->accreditationRepository->edit($id);
        }
        return view('admin.institute.edit',compact('instituteCategory','institutePage','positions','locales','currentLang'));
    }

    public function update(InstituteRequest $instituteRequest, $id)
    {
        try {
            $instituteCategory = InstituteCategory::where(['slug->'.$this->currentLang => $instituteRequest['category_slug'],'status' => 1])->first();
            $institutePage = null;
            $table = null;
            $dataUp = false;
            if ($instituteCategory['page_type'] == 'slide_content') {
                $institutePage = $this->aboutRepository->edit($id);
                $data = AboutHelper::data($instituteRequest,$institutePage,$instituteCategory['id']);
                $dataUp = $this->aboutRepository->update($id,$data);
                $table = 'abouts';
            }elseif ($instituteCategory['page_type'] == 'file_content') {
                $institutePage = $this->charterRepository->edit($id);
                $data = CharterHelper::data($instituteRequest,$institutePage,$instituteCategory['id']);
                $dataUp = $this->charterRepository->update($id,$data);
                $table = 'charters';
            }elseif ($instituteCategory['page_type'] == 'image_content') {
                $institutePage = $this->leaderShipRepository->edit($id);
                $data = LeaderShipHelper::data($instituteRequest,$institutePage,$instituteCategory['id']);
                $dataUp = $this->leaderShipRepository->update($id,$data);
                $table = 'leaderships';
            }elseif ($instituteCategory['page_type'] == 'content') {
                $institutePage = $this->structureRepository->edit($id);
                $data = StructureHelper::data($instituteRequest,$institutePage,$instituteCategory['id']);
                $dataUp = $this->structureRepository->update($id,$data);
                $table = 'structures';
            }elseif ($instituteCategory['page_type'] == 'photo') {
                $institutePage = $this->accreditationRepository->edit($id);
                $data = AccreditationHelper::data($instituteRequest,$institutePage,$instituteCategory['id']);
                $dataUp = $this->accreditationRepository->update($id,$data);
                $table = 'accreditations';
            }
            $messages = !empty($dataUp)? Lang::get('admin.up_success'): Lang::get('admin.up_error');
            $logData = [
                'subj_id' => $id,
                'subj_table' => $table,
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
                'subj_table' => $table,
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }



    public function destroy(Request $request,$id)
    {
        try {
            $instituteCategory = InstituteCategory::where(['slug->'.$this->currentLang => $request->category_slug,'status' => 1])->first();

            if (empty($instituteCategory)){
                return redirect(route('admin.index'));
            }
            $institutePage = null;
            if ($instituteCategory['page_type'] == 'image_content'){
                $institutePage = $this->leaderShipRepository->delete($id);
                $table = 'leaderships';
            }elseif ($instituteCategory['page_type'] == 'content'){
                $institutePage = $this->structureRepository->delete($id);
                $table = 'structures';
            }elseif ($instituteCategory['page_type'] == 'photo'){
                $institutePage = $this->accreditationRepository->delete($id);
                $table = 'accreditations';
            }
            $messages = Lang::get('admin.delete_success');
            $logData = [
                'subj_id' => $id,
                'subj_table' => $table,
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('success', $messages);
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'institute',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', 'errors ' . $messages);
        }
    }
}
