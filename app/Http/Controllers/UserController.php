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
            'txt_employee_number' => 'required',
            'txt_password' => 'required',
        ], [
            'txt_employee_number.required' => 'The Employee Number is required!',
            'txt_password.required' => 'The Password is required!',
        ]);
        
        $credentials = [
            'employee_number' => $request->txt_employee_number,
            'password' => $request->txt_password,
        ];

        if (Auth::attempt($credentials)) {
            if (Auth::user()->roles->level === "ADMIN") {
                return redirect('users/administrator');
            } else {
                return redirect('users/normal-users');
            }
        } else {
            return redirect()->back()->withErrors($validator->errors());
        }
    }

    public function sign_out()
    {
        Auth::logout();
        return redirect('mms-login');
    }

    public function administrator()
    {
        // return Auth::user();
        return "Administrator";
    }

    public function users()
    {
        // return Auth::user();
        return "Users";
    }
}