<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\LoginRequest;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    use ApiResponses;

    public function login(LoginRequest $request)
    {
//      dd($request->validated());
        $request->validated($request->all());
        if(!Auth::attempt($request->only('email','password'))){
            return $this->error('Invalid credentials',401 );
        }
        $useer = Auth::user();
        $user = User::where('email',$request->email)->first();
//        dd($user->name,$useer->name);
        return $this->ok
        ('Authenticated',
            [
                'token'=> $user->createToken('API token for ' . $user->email)->plainTextToken
            ]
        );
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return $this->ok('');
    }

    public function register()
    {
        return $this->ok('hi');
    }
}
