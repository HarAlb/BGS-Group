<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
// Request Types
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Auth\Login;
use Illuminate\Http\Request;

// Models
use App\User;

// Helper Functions
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ApiAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['logout' , 'user']);
    }

    public function register(Register $req)
    {
        $user_array = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ];

        if($user = User::create($user_array)) {
            $token_resault = $user->createToken('Laravel Password Grant Client');

            $token = $token_resault->token;
            $token->save();

            return response(['token' => $token_resault->accessToken , 'token_type' => 'Bearer'], 200);
        }

        return response(['message' => 'Internal Server Error , Please try letter'] , 500);
    }

    public function login(Login $req)
    {
        if(Auth::attempt(['email' => $req->email, 'password' => $req->password])){
            $user = $req->user();
            $token_resault = $user->createToken('Laravel Password Grant Client');
            $token = $token_resault->token;
            $token->save();

            return response(['token' => $token_resault->accessToken , 'token_type' => 'Bearer'], 200);
        }
        return response(['message'=> 'Password Dosn\'t Check'] , 422);
    }
    // Didn't Use Custom request type becouse check.token midleware do what I need
    public function logout(Request $req)
    {
        // $req->user()->token()->revoke();

        return response(['message' => 'Successfully logged out'] , 200);
    }

    public function user(Request $request)
    {
        return response($request->user() , 200);
    }
}
