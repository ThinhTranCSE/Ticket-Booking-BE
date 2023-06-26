<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Model\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\User as UserAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    private const CREATE_TOKEN_STRING = 'ticket-booking-app';
    static function login(Request $req){
        $input = $req->only('username', 'password');
        if(!Auth::attempt($input)){
            return response()->json([
                'error' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();
        $token = $user->createToken(AuthController::CREATE_TOKEN_STRING)->accessToken;
        return response()->json([
            'user' => new UserCollection($user),
            'token' => $token,
            'message' => 'Login succeed'
        ]);
    }

    static function register(Request $req){
        try{
            $req->validate([
                'username' => [
                    'required',
                    'max:255',
                    Rule::unique('App\Model\User', 'username')
                ],
                'password' => [
                    'required',
                    'min:8',
                    "max:255",
                ],
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'error' => $err->validator->errors()
            ], $err->status);
        }
        $input = $req->all();
        $input['password'] = Hash::make($input['password']);
        $input['role'] = 'user';
        $user = UserAuth::create($input);

        $token = $user->createToken(AuthController::CREATE_TOKEN_STRING)->accessToken;
        return response()->json([
            'user' => new UserCollection($user),
            'token' => $token,
            'message' => 'Register succeed'
        ]);
    }

    static function logout(Request $req){
        Auth::user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
