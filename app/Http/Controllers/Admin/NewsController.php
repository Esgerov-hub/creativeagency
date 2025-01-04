<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NewsHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\Category;
use App\Models\News;
use App\Models\Translation;
use App\Repositories\NewsRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewsController extends Controller
{
    protected $newsRepository;
    protected $currentLang;

    public function __construct(NewsRepositoryImpl $newsRepository)
    {
        $this->newsRepository = $newsRepository;
        $this->currentLang = LaravelLocalization::getCurrentLocale();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = $this->newsRepository->getAll();
        $currentLang = $this->currentLang;
        return view('admin.news.index',compact('news','currentLang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locales = Translation::where('status',1)->get();
        $categories = Category::orderBy('id','DESC')->get();
        $currentLang = $this->currentLang;
        return view('admin.news.create', compact('locales','categories','currentLang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $newsRequest)
    {
        try {
            $data = NewsHelper::data($newsRequest);
            $news = $this->newsRepository->create($data);
            if ($news) {
                $messages = Lang::get('admin.add_success');
            }else{
                $messages = Lang::get('admin.add_error');
            }
            $logData = [
                'subj_id' => $news->id,
                'subj_table' => 'news',
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
                'subj_table' => 'news',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(News $news)
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
        $news = $this->newsRepository->edit($id);
        $locales = Translation::where('status',1)->get();
        $categories = Category::orderBy('id','DESC')->get();
        $currentLang = $this->currentLang;
        return view('admin.news.edit', compact('locales','news','categories','currentLang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $newsRequest, $id)
    {
        try {
            $news = News::where('id',$id)->first();
            $data = NewsHelper::data($newsRequest,$news);
            $newsUp = $this->newsRepository->update($id,$data);
            if ($newsUp) {
                $messages = Lang::get('admin.up_success');
            }else{
                $messages = Lang::get('admin.up_error');
            }
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'news',
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
                'subj_table' => 'news',
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
            $news = News::where('id',$id)->first();
            if ($this->newsRepository->delete($news['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'news',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success',$messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'news',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $messages);
        }
    }
}
