<?php

namespace App\Services\Master;

use App\Repositories\Master\MasterUsersRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MasterUsersService
{
    protected $masterUsersRepository;

    public function __construct(MasterUsersRepositoryInterface $masterUsersRepository)
    {
        $this->masterUsersRepository = $masterUsersRepository;
    }

    public function updateUserProfile(array $data)
    {
        $user = Auth::user();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:Master_Users,phone,' . $user->id . '|max:255',
            'ktp' => 'required|string|unique:Master_Users,ktp,' . $user->id,
            'dob' => 'required|date',
            'address' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);


        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        $result = $this->masterUsersRepository->updateUserProfile($data, $user->id);      
        
        if (isset($result['error'])) {
            return $result;
        }
        return ['message' => 'Update profile success', 'data' => ['user' => $result]];
    }   
    
    public function updatePassword(array $data)
    {
        $user = Auth::user();

        $validator = Validator::make($data, [
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed|different:current_password',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        if (!Hash::check($data['current_password'], $user->password)) {
            return ['error' => 'The current password is incorrect.'];
        }

        $data['new_password'] = Hash::make($data['new_password']);
        $result = $this->masterUsersRepository->updatePassword($data, $user->id);      

        if (isset($result['error'])) {
            return $result;
        }        

        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return ['message' => 'Update password success', 'data' => ['user' => $result]];
    }
}
