<?php

namespace StateOfMotion\Authentication;

use Illuminate\Support\ServiceProvider;
use StateOfMotion\Authentication\Commands\BuildControllerCommand;
use StateOfMotion\Authentication\Commands\BuildWebmixCommand;

class AuthenticationServiceProvider extends ServiceProvider {
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BuildControllerCommand::class,
                BuildWebmixCommand::class,
            ]);
        }
    }
}
