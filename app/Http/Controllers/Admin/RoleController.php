<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionLabel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use \Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:roles-view'])->only('index');
        $this->middleware(['permission:roles-create'])->only(['create','store']);
        $this->middleware(['permission:roles-edit'])->only(['edit','update']);
        $this->middleware(['permission:roles-delete'])->only(['index','destroy']);
    }

    public function index()
    {
        $roles = Role::orderBy('name','ASC')->get();
        return view('admin.roles.index',['roles'=>$roles]);
    }


    public function create()
    {
        $role = null;
        $permissionLabels = PermissionLabel::with('permissions')->orderBy('label','ASC')->get();
        return view('admin.roles.create_edit',['permissionLabels' => $permissionLabels,'role' => $role]);
    }

    public function store(Request $request)
    {
        $valdate = Validator::make([
            'role' => $request->role,
            'permissions' => $request->permissions
        ], [
            'role' => 'required',
            'permissions' => 'required'
        ], [
            '*.required' =>  Lang::get('validation.required', ['attribute' => ':attribute']),
        ]);

        if ($valdate->fails())
        {
            return redirect()->back()->with('errors', $valdate->errors());
        }
        try {
            $role = Role::firstOrCreate(['name' => $request->role,'guard_name' => 'admin']);
            $role->syncPermissions($request->permissions);
            DB::commit();
            $messages = Lang::get('admin.add_success');
            $logData = [
                'subj_id' => $role->id,
                'subj_table' => 'roles',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('success', $messages);

        } catch (\Exception $e) {
            DB::rollBack();
            $messages = $e->getMessage();
            $logData = [
                'subj_id' => null,
                'subj_table' => 'roles',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', $messages);
        }
    }


    public function show(Role $role)
    {
        //
    }


    public function edit($id)
    {
        try{
            $role = Role::where('id',$id)->first();
            $permissionLabels = PermissionLabel::with('permissions')->orderBy('id','DESC')->get();
            $permissionsSelected = $role->permissions()->get();

            $data = [];
            foreach ($permissionsSelected as $permission){
                $data[] = $permission->name;
            }
            return view('admin.roles.create_edit',['role' => $role,'permissionLabels' => $permissionLabels,'selectedPermissions' => $data]);
        }catch (\Throwable $exception){
            return redirect()->back()->with('fail',$exception->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $valdate = Validator::make([
            'role' => $request->role
        ], [
            'role' => 'required',
        ], [
            '*.required' =>  Lang::get('validation.required', ['attribute' => ':attribute']),
        ]);

        if ($valdate->fails())
        {
            return redirect()->back()->with('errors', $valdate->errors());
        }

        try {
            if(empty($request->permissions)){
                return redirect()->back()->with('errors','Check your role permissions.');
            }

            $role = Role::findOrFail($id);
            $role->update([
                'name' => $request->role,
                'guard_name' => 'admin'
            ]);
            $role->syncPermissions($request['permissions']);

            $messages = Lang::get('admin.up_success');
            $logData = [
                'subj_id' => $role->id,
                'subj_table' => 'roles',
                'description' => $messages,
            ];
            DB::commit();
            saveLog($logData);
            return redirect()->back()->with('success', $messages);
        } catch (\Exception $e) {
            DB::rollBack();
            $messages = $e->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'roles',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors', $messages);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::where('id',$id)->first();
            if ($role->delete()) {
                $messages = Lang::get('admin.delete_success');
                $logData = [
                    'subj_id' => $id,
                    'subj_table' => 'roles',
                    'description' => $messages,
                ];
                saveLog($logData);
                return redirect()->back()->with('success', $messages);
            }
        } catch (\Exception $exception) {
            $messages = $exception->getMessage();
            $logData = [
                'subj_id' => $id,
                'subj_table' => 'roles',
                'description' => $messages,
            ];
            saveLog($logData);
            return redirect()->back()->with('errors','errors '. $messages);
        }
    }
}
