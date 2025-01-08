<?php

namespace App\Repositories\Master;

use App\Models\Master\MasterUsers;
use App\Repositories\Master\MasterUsersRepositoryInterface;


class MasterUsersRepository implements MasterUsersRepositoryInterface
{
    public function updateUserProfile(array $data, $id)
    {
        $user = MasterUsers::find($id);

        if($user){
            $user->update($data);
        
            return $user;
        }

        return ['error' => "User not found"];
    }

    public function updatePassword(array $data, $id)
    {
        $user = MasterUsers::find($id);

        if($user){
            
            $user->password = $data['new_password'];
            $user->save();

            return $user;
        }

        return ['error' => "User not found"];
    }

}