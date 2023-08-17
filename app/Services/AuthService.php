<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthService {
    public function login($request): mixed
    {
        if(Auth::guard('web')->attempt($request)){
            $user = Auth::user();
            $token = $user->createToken('LaravelSanctumAuth')->plainTextToken;
            return $token;
        } else {
            return null;
        }
    }

    public function register($request): mixed
    {
        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->save();
        if($user) {
            $token = $user->createToken('LaravelSanctumAuth')->plainTextToken;
            return $token;
        } else {
            return null;
        }
    }
}
