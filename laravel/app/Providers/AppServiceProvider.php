<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Master\MasterUsersRepositoryInterface;
use App\Repositories\Master\MasterUsersRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //auth
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        
        //master users
        $this->app->bind(MasterUsersRepositoryInterface::class, MasterUsersRepository::class);
        
    }

    public function boot()
    {
        //
    }
}
