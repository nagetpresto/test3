<?php

namespace App\Repositories\Auth;

use App\Models\Master\MasterUsers;
use App\Repositories\Auth\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function createUser(array $data)
    {
        return MasterUsers::create($data);
    }

    public function verifyEmail($id, $hash)
    {
        $user = MasterUsers::find($id);

        if(!$user){
            return ['error' => "User not found"];
        }
        
        if ($user->is_verified === false) {
            $user->update([
                'is_verified' => true,
                'verified_date' => new \DateTime()
            ]);
            return $user;
        }

        return ['error' => 'Invalid verification token.'];
    }
}