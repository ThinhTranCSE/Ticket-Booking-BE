<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Model\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    static function getAllUsers(){
        $users = User::getAllUsers();
        return UserCollection::collection($users);
    }

    static function getUserById($id){
        try{
            Validator::make(['id' => $id], [
                'id' => [
                    'integer'
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'error' => $err->validator->errors()
            ], $err->status);
        }
        $user = User::getUserById($id);
        return new UserCollection($user);
    }
    static function createUser(Request $req){
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
                'role' => [
                    Rule::in(User::USER_ROLE)
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'error' => $err->validator->errors()
            ], $err->status);
        }
        $user = User::createUser($req->all());
        return new UserCollection($user);
    }

    static function updateUser(Request $req, $id){
        try{
            $req->validate([
                'password' => [
                    'min:8',
                    "max:255",
                ],
                'role' => [
                    Rule::in(User::USER_ROLE)
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'error' => $err->validator->errors()
            ], $err->status);
        }
        $user = User::updateUser($req->all(), $id);
        return new UserCollection($user);
    }

    static function deleteUseById($id){
        try{
            Validator::make(['id' => $id], [
                'id' => [
                    'integer'
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'error' => $err->validator->errors()
            ], $err->status);
        }
        $user = User::deleteUserById($id);
        return new UserCollection($user);
    }
}
