<?php

namespace StateOfMotion\Authentication;

use Illuminate\Support\ServiceProvider;
use StateOfMotion\Authentication\Commands\BuildControllerCommand;

class AuthenticationServiceProvider extends ServiceProvider {
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BuildControllerCommand::class
            ]);
        }
    }
}
