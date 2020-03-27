<?php

namespace StateOfMotion\Authentication\Commands;

use Illuminate\Console\Command;
use StateOfMotion\Authentication\Controllers\WebLoginController;

class BuildControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stateofmotion:auth {name} {--W|web} {--M|mobile} {--L|login} {--R|register}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate auth controllers more suited for asynchronous attempts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $controllerName = $this->argument('name');

        $web = $this->option('web');
        $mobile = $this->option('mobile');
        $register = $this->option('register');
        $login = $this->option('login');
        $platform = NULL;
        $type = NULL;

        // Check if both mobile and web were set and error out if so
        if ($web && $mobile) {
            $this->error('Cannot choose both mobile and web');
            return;
        } else if (!($web || $mobile)) {
            $this->error('Must choose either mobile or web option');
        } else if ($web) {
            $platform = 'web';
        } else {
            $platform = 'mobile';
        }

        // Check if both login and register were selected and error out if so
        if ($login && $register) {
            $this->error("Cannot choose both register and login");
            return;
        } else if (!($login || $register)) {
            $this->error('Must choose either Login or Register controller type');
        } else if ($login) {
            $type = 'login';
        } else {
            $type = 'mobile';
        }

        $controllerName = $this->argument('name');
        $path = app_path() . '/Http/Controllers/' . $controllerName . '.php';

        if ($type == 'login' && $platform == 'web') {
            $className = WebLoginController::class;
        }

        if (!file_exists($path)) {
            $this->info('path doesnt exist, creating...');
            $rc = new \ReflectionClass($className);
            $filePath = $rc->getFileName();
            $this->mycopy($filePath, $path);
        }
    }

    public function mycopy($s1, $s2)
    {
        $path = pathinfo($s2);
        if (!file_exists($path['dirname'])) {
            mkdir($path['dirname'], 0777, true);
        }
        if (!copy($s1, $s2)) {
           info("There was a problem creating a file");
        }
    }
}
