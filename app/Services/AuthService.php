<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
  public function login($credentials)
  {
      // Try to authenticate and get the token
      $token = Auth::attempt($credentials);

      if (!$token) {
          return [
              'status' => 'error',
              'message' => 'Unauthorized',
          ];
      }
      return [
          'status' => 'success',
          'user' => Auth::user(),
          'authorization' => [
              'token' => $token,  // Use the token directly
              'type' => 'bearer',
          ]
      ];
  }

    public function register($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = Auth::login($user);

        return [
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ];
    }

    public function logout()
    {
        Auth::logout();
        return [
            'status' => 'success',
            'message' => 'Successfully logged out',
        ];
    }

    public function refresh()
    {
        return [
            'status' => 'success',
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ];
    }
}
