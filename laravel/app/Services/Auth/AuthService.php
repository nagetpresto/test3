<?php

namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:Master_Users,email',
            'phone' => 'required|string|unique:Master_Users,phone|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        $data['password'] = Hash::make($data['password']);

        $user = $this->authRepository->createUser($data);

        $user->sendEmailVerificationNotification();

        return ['message' => 'Registration success. A verification email has been sent','data' => ['user' => $user]];
    }

    public function verifyEmail($id, $hash)
    {
        $result = $this->authRepository->verifyEmail($id, $hash);

        if (isset($result['error'])) {
            return $result;
        }

        return ['message' => 'Email verified successfully.'];
    }

    public function login(array $credentials)
    {
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('login')->plainTextToken;

            return ['message' => 'Login success', 'data' => ['user' => $user], 'token' => $token, 'expires' => '2 hours'];
        }

        return ['error' => 'Invalid credentials'];
    }

    public function logout()
    {
        $user = Auth::user();

        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return ['message' => 'Logout success'];
    }
}
