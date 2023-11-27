<?php

namespace App\Repositories\User;

use App\Interfaces\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function attemptLogin($credentials)
    {
        if (!$token = auth()->attempt($credentials)) {
            return false;
        }
        return $token;
    }


    public function createNewUser($userData)
    {
        return User::create(array_merge($userData, ['password' => bcrypt($userData['password'])]));
    }


    public function logoutUser()
    {
        auth()->logout();
    }


    public function refreshToken()
    {
        return $this->createNewToken(Auth::refresh());
    }


    public function getUserProfileData()
    {
        return auth()->user();
    }


    public function createNewToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => auth()->user()
        ];
    }
}
