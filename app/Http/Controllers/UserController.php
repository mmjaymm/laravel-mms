<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login_auth']]);
        $this->middleware('validate-back-history')->except('sign_out');
    }

    public function login_auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_number' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = [
            'employee_number' => $request->employee_number,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            if (Auth::user()->roles->level === "ADMIN") {
                return redirect('users/administrator');
            } else {
                return redirect('users/normal-users');
            }
        } else {
            return back();
        }
    }

    public function sign_out()
    {
        Auth::logout();
        return redirect('mms-login');
    }

    public function administrator()
    {
        return Auth::user();
        return "Administrator";
    }

    public function users()
    {
        return Auth::user();
    }
}