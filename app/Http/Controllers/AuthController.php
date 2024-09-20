<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $result = $this->authService->login($credentials);

        return $result['status'] === 'success'
            ? ResponseHelper::success($result, 'loggedIn Successfully', 200)
            : ResponseHelper::error($result['message'], 401);
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->all());

        return ResponseHelper::success($result, 'Registered Successfully', 201);
    }

    public function logout()
    {
        $result = $this->authService->logout();

        return ResponseHelper::success([], $result['message'], 200);
    }

    public function profile()
    {
        return ResponseHelper::success(['user' => Auth::user()], 'Profile', 200);
    }

    public function refresh()
    {
        $result = $this->authService->refresh();

        return ResponseHelper::success($result, 'Refreshed', 200);
    }
}
