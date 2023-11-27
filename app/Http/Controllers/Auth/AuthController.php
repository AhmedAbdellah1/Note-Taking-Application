<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Interfaces\User\UserRepositoryInterface;

class AuthController extends Controller
{

    protected $userRepository;


    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;

        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function login(UserLoginRequest $request)
    {

        $token = $this->userRepository->attemptLogin($request->validated());

        return $token
            ? response()->json($this->userRepository->createNewToken($token))
            : response()->json(['error' => 'Unauthorized'], 401);
    }


    public function register(UserRegisterRequest $request)
    {

        $user = $this->userRepository->createNewUser($request->validated());

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    public function logout()
    {
        $this->userRepository->logoutUser();
        return response()->json(['message' => 'User successfully signed out']);
    }


    public function refresh()
    {
        return response()->json($this->userRepository->refreshToken());
    }


    public function userProfile()
    {
        return response()->json($this->userRepository->getUserProfileData());
    }
}
