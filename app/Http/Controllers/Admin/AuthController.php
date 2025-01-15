<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        if (!empty(auth('admin')->user())) {
            return redirect()->route('admin.index');
        }
        return view('admin.auth.login');
    }

    public function loginAccept(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $valdate = Validator::make([
            'email' => $email,
            'password' => $password
        ], [
            'email' => 'required|email',
            'password' => ['required', 'min:6'/*, 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&]/'*/],
        ], [
            '*.required' => Lang::get('validation.required', ['attribute' => ':attribute']),
            'password.min' => Lang::get('validation.min.string', ['attribute' => 'password', 'min' => 6]),
            'password.regex' => Lang::get('validation.regex', ['attribute' => 'password']),
        ]);

        if ($valdate->fails())
        {
            return redirect()->back()->with('errors', $valdate->errors());
        }elseif ($valdate->passes()) {
            $loginState = [
                'email' => $email,
                'password' => $password
            ];

            if (!empty(auth('admin')->attempt($loginState))) {
                return redirect(route('admin.index'))->with('success', Lang::get('admin.success_login'));
            } else {
                return redirect()->back()->with('errors', Lang::get('admin.error_login'));
            }
        }
    }

    public function logout()
    {
        auth('admin')->logout(); // admin guard-ı ilə çıxış et
        \Session::forget('admin_data');
        return redirect(route('admin.login'))->with('success', Lang::get('admin.success_logout'));
    }
}
