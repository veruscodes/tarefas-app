<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        $data = $r->validate([
            'company_name'=>'required',
            'company_slug'=>'required|alpha_dash|unique:companies,slug',
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6'
        ]);

        $company = Company::create([
            'name'=>$data['company_name'],
            'slug'=>$data['company_slug']
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
            'company_id'=>$company->id
        ]);

        $token = auth('api')->login($user);

        return response()->json([
            'token'=>$token,
            'user'=>$user,
            'company'=>$company
        ], 201);
    }

    public function login(Request $r)
    {
        $creds = $r->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(!$token = auth('api')->attempt($creds)){
            return response()->json(['message'=>'Unauthorized'],401);
        }

            return response()->json([
        'token'=>$token,
        'user'=>auth('api')->user()->load('company')
        ]);
    }

    public function me()
    {
        return response()->json(auth('api')->user()->load('company'));
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json();
    }

    public function refresh()
    {
        return response()->json(['token'=>auth('api')->refresh()]);
    }
}
