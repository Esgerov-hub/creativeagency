<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CmsUserHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CmsUserRequest;
use App\Models\CmsUser;
use App\Models\Log;
use App\Repositories\CmsUserRepositoryImpl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class CmsUserController extends Controller
{
    protected $cmsUserRepository;

    public function __construct(CmsUserRepositoryImpl $cmsUserRepository)
    {
        $this->cmsUserRepository = $cmsUserRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cms_users = $this->cmsUserRepository->getAll();
        return view('admin.cms-users.index',compact('cms_users'));
    }

    public function logs()
    {
        $logs = Log::with('cms_user')
            ->orderBy('datetime', 'DESC')->get();
        return view('admin.cms-users.logs',compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('name','ASC')->get();
        return view('admin.cms-users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CmsUserRequest $cmsUserRequest)
    {
        $valdate = Validator::make([
            'password' => $cmsUserRequest->password,
        ], [
            'password' => [
                'required',
                'min:8', // Minimum length of 8 characters
                'regex:/[a-z]/', // Must contain at least one lowercase letter
                'regex:/[A-Z]/', // Must contain at least one uppercase letter
                'regex:/[0-9]/', // Must contain at least one digit
                'regex:/[@$!%*?&]/' // Must contain a special character
            ],
        ], [
            '*.required' => Lang::get('validation.required', ['attribute' => ':attribute']),
            'password.min' => Lang::get('validation.min.string', ['attribute' => 'password', 'min' => 8]),
            'password.regex' => Lang::get('validation.regex', ['attribute' => 'password']),
        ]);

        if ($valdate->fails())
        {
            return redirect()->back()->with('errors', $valdate->errors());
        }

        try {
            $user = NULL;
            $data = CmsUserHelper::data($cmsUserRequest,$user);
            $cmsUser = $this->cmsUserRepository->create($data);
            if (isset($cmsUserRequest->role) && !empty($cmsUserRequest->role)) {
                $cmsUser->assignRole($cmsUserRequest->role);
            }
            $messages = Lang::get('admin.add_success');
            $logData = [
                'subj_id' => $cmsUser->id,
                'subj_table' => 'cms_users',
                'description' => $messages,
            ];
            saveLog($logData);
            DB::commit();
            return redirect()->back()->with('success',$messages);
        }catch (\Exception $e){
            DB::rollBack();
            $messages = $e->getMessage();
            $logData = [
                'subj_id' => null,
                'subj_table' => 'cms_users',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', $messages);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CmsUser  $cmsUser
     * @return \Illuminate\Http\Response
     */
    public function show(CmsUser $cmsUser)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CmsUser  $cmsUser
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cmsUser = CmsUser::where('id',$id)->first();
        $roles = Role::orderBy('name','ASC')->get();
        return view('admin.cms-users.edit',compact('roles','cmsUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CmsUser  $cmsUser
     * @return \Illuminate\Http\Response
     */
    public function update(CmsUserRequest $cmsUserRequest, $id)
    {

        if (!empty($cmsUserRequest->password)){
            $valdate = Validator::make([
                'password' => $cmsUserRequest->password,
            ], [
                'password' => ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&]/'],
            ], [
                '*.required' => Lang::get('validation.required', ['attribute' => ':attribute']),
                'password.min' => Lang::get('validation.min.string', ['attribute' => 'password', 'min' => 8]),
                'password.regex' => Lang::get('validation.regex', ['attribute' => 'password']),
            ]);

            if ($valdate->fails())
            {
                return redirect()->back()->with('errors', $valdate->errors());
            }
        }
        try {
            $cmsUser = CmsUser::where('id',$id)->first();
            $data = CmsUserHelper::data($cmsUserRequest,$cmsUser);
            $this->cmsUserRepository->update($id,$data);
            if (isset($cmsUserRequest->role) && !empty($cmsUserRequest->role)) {
                DB::table('model_has_roles')->where('model_id',$id)->delete();
                $cmsUser->assignRole($cmsUserRequest->role);
            }
            $messages = Lang::get('admin.up_success');
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'cms_users',
                'description' => $messages,
            ];
            saveLog($logData);
            DB::commit();
            return redirect()->back()->with('success',$messages);
        }catch (\Exception $e){
            DB::rollBack();
            $messages = $e->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'cms_users',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', $messages);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CmsUser  $cmsUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cms_user = CmsUser::where('id',$id)->first();
            if ($this->cmsUserRepository->delete($cms_user['id'])) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'cms_users',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success',$messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'cms_users',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $messages);
        }
    }
}
