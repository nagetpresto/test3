<?php

namespace App\Repositories\Master;

interface MasterUsersRepositoryInterface
{
    public function updateUserProfile(array $data, $id);
    public function updatePassword(array $data, $id);
}
