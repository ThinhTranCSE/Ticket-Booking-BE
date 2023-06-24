<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    const USER_ROLE = ['user', 'admin'];
    
    static function getAllUsers(){
        $users = User::all();
        return $users;
    }

    static function getUserById(int $id){
        $user = User::query()->findOrFail($id);
        dd($user);
        return $user;
    }

    static function createUser($user_data){
        $user = new User;
        $user->username = $user_data['username'];
        $user->password = Hash::make($user_data['password']);
        $user->role = $user_data['role'];
        
        $user->save();

        return $user;
    }

    static function updateUser($user_data, int $id){
        $user = User::findOrFail($id);
        $user_data['password'] ? $user->password = Hash::make($user_data['password']) : null;
        $user_data['role'] ? $user->role = $user_data['role'] : null;
        
        $user->save();

        return $user;
    }

    static function deleteUserById(int $id){
        $user = User::findOrFail($id)->delete();
        return $user;
    }
}
