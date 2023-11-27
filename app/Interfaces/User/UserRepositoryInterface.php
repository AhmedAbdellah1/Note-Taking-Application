<?php

namespace App\Interfaces\User;

interface UserRepositoryInterface
{
    public function attemptLogin($credentials);
    public function createNewUser($userData);
    public function logoutUser();
    public function refreshToken();
    public function getUserProfileData();
    public function createNewToken($token);
}
