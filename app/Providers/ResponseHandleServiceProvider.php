<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ResponseHandleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
        
        'App\ResponseHandler\ResponseHandle',function ($app) {
          return new ResponseHandle();
        });
    }
}
