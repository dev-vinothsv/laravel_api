<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CarServiceProvider extends ServiceProvider
{
    public function register()
    {
     
		 $this->app->bind(
            'App\Repositories\CarRepositoryInterface',
            'App\Repository\CarRepository'
        );
    }
}
