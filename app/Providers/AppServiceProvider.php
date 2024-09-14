<?php

namespace App\Providers;

use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\BaseRepository\BaseRepositoryInterface;
use App\Repositories\UserRepository\UserRepository;
use App\Repositories\UserRepository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider{
    public function register(): void{
        $this->app->register(BaseRepositoryInterface::class,BaseRepository::class);
        $this->app->register(UserRepositoryInterface::class,UserRepository::class);
    }

    public function boot(): void{
        //
    }
}
