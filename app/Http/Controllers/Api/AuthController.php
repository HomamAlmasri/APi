<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\LoginRequest;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    use ApiResponses;

    public function login(LoginRequest $request)
    {
        //GET THE USER INPUT
        $auth = $request->input('login');
        //CHECKING IF THE INPUT TYPE IS EMAIL OR USERNAME AND SETTING THE FIELD TYPE TO EITHER 'email' OR 'username'
        $fieldType = ctype_digit($auth) ? 'phone_number' : (filter_var($auth, FILTER_VALIDATE_EMAIL) ? 'email' : 'name');
        //VALIDATING THE REQUEST DATA AGAINST THE DEFINED VALIDATION RULES
        $request->validated();
        //SETTING KEY TO THE VALUE AUTH
        $request->merge([$fieldType=>$auth]);
        //CHECKING IF THE CREDENTIALS ARE CORRECT
        if (!Auth::attempt($request->only($fieldType,'password')))
        {
            return $this->error('Invalid credentials', 401);
        }
        //RETRIEVING THE CURRENTLY AUTHENTICATED USER DATA
        $user = auth()->user();

        return $this->ok('Authenticated',[
            'token' => $user->createToken('Api Token For ' . $user->email)->plainTextToken
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->ok('');
    }

    public function register()
    {
        return $this->ok('hi');
    }
}
