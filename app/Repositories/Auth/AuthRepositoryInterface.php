<?php

namespace App\Repositories\Auth;

interface AuthRepositoryInterface
{
    public function createUser(array $data);
    public function verifyEmail($id, $hash);
}
