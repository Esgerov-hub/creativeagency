<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TranslationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TranslationsRequest;
use App\Models\Translation;
use App\Repositories\TranslationRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TranslationsController extends Controller
{
    protected $translationRepository;

    public function __construct(TranslationRepositoryImpl $translationRepository)
    {
        $this->translationRepository = $translationRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $translations = $this->translationRepository->getAll();
        return view('admin.translations.index', compact('translations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TranslationsRequest $translationsRequest)
    {
        try {
            $data = TranslationHelper::data($translationsRequest);
            if ($this->translationRepository->create($data)) {
                return redirect()->back()->with('success', Lang::get('admin.success'));
            }
        } catch (\Exception $exception) {

            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function show(Translation $translation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function edit(Translation $translation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Translation $translation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Translation $translation)
    {
        //
    }

    //admin
    public function admin_word_index()
    {
        $translations = Translation::where('status', 1)->get();
        return view('admin.translations.admin_word_index', compact('translations'));
    }

    public function admin_word_edit($code)
    {
        $translation = Translation::where(['status' => 1, 'code' => $code])->first();

        if (!empty($translation)) {
            $words = lang_path() . "/" . $code . "/admin.php";
            $siteStatisticsData = include $words;
        }
        return view('admin.translations.admin_word_edit', compact('translation', 'siteStatisticsData'));
    }

    public function admin_word_update($code, Request $request)
    {
        $translation = Translation::where(['status' => 1, 'code' => $code])->first();

        if (!empty($translation)) {
            $words = lang_path() . "/" . $code . "/admin.php";
            $siteStatisticsData = include $words;
            foreach ($request->all() as $key => $value) {
                if (!empty($siteStatisticsData[$key])) {
                    $siteStatisticsData[$key] = $value;
                }
            }
            $result = file_put_contents($words, '<?php return ' . var_export($siteStatisticsData, true) . ';');
            if (!empty($result)) {
                $messages = Lang::get('admin.add_success');
                $logData = [
                    'subj_id' => $translation->id,
                    'subj_table' => 'translations',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success',  $messages. $result);
            } else {
                $messages = Lang::get('admin.add_error');
                $logData = [
                    'subj_id' => $translation->id,
                    'subj_table' => 'translations',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('errors', $messages . $result);
            }
        }
        $messages = Lang::get('admin.add_error');
        $logData = [
            'subj_id' => $translation->id,
            'subj_table' => 'translations',
            'description' => $messages,
        ];
        saveLog($logData);
        return redirect()->back()->with('errors', $messages);
    }

    //site
    public function site_word_index()
    {
        $translations = Translation::where('status', 1)->get();
        return view('admin.translations.site_word_index', compact('translations'));
    }

    public function site_word_edit($code)
    {
        $translation = Translation::where(['status' => 1, 'code' => $code])->first();

        if (!empty($translation)) {
            $words = lang_path() . "/" . $code . "/site.php";
            $siteStatisticsData = include $words;
        }
        return view('admin.translations.site_word_edit', compact('translation', 'siteStatisticsData'));
    }

    public function site_word_update($code, Request $request)
    {
        $translation = Translation::where(['status' => 1, 'code' => $code])->first();

        if (!empty($translation)) {
            $words = lang_path() . "/" . $code . "/site.php";
            $siteStatisticsData = include $words;
            foreach ($request->all() as $key => $value) {
                if (!empty($siteStatisticsData[$key])) {
                    $siteStatisticsData[$key] = $value;
                }
            }
            $result = file_put_contents($words, '<?php return ' . var_export($siteStatisticsData, true) . ';');
            if (!empty($result)) {
                $messages = Lang::get('admin.add_success') .'- site';
                $logData = [
                    'subj_id' => $translation->id,
                    'subj_table' => 'translations',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success',  $messages. $result);
            } else {
                $messages = Lang::get('admin.add_error') .'- site';
                $logData = [
                    'subj_id' => $translation->id,
                    'subj_table' => 'translations',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('errors', $messages . $result);
            }
        }
        $messages = Lang::get('admin.add_error') .'- site';
        $logData = [
            'subj_id' => $translation->id,
            'subj_table' => 'translations',
            'description' => $messages,
        ];
        saveLog($logData);
        return redirect()->back()->with('errors', $messages);
    }
}
