<?php

namespace StateOfMotion\Authentication\Commands;

use Illuminate\Console\Command;
use StateOfMotion\Authentication\Controllers\WebLoginController;

class BuildWebmixCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stateofmotion:webmix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generat custom webmix file with hot reloading enabled';

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
        $doesntExist = app_path() . '/../webpack.mix.js';
        $exists = app_path() . '/../webpack.mix.new.js';

        if (!file_exists($doesntExist)) {
            $this->info('webpack.mix.js doesnt exist. creating');
            $this->mycopy(dirname(__FILE__).'/../app/webpack.mix.js', $doesntExist);
        } else {
            $this->info('webpack.mix.js exists, creating new webpack.mix.new.js file');
            $this->mycopy(dirname(__FILE__).'/../app/webpack.mix.js', $exists);
        }
    }

    public function mycopy($s1, $s2)
    {
        $path = pathinfo($s2);
        if (!file_exists($path['dirname'])) {
            mkdir($path['dirname'], 0777, true);
        }
        if (!copy($s1, $s2)) {
            $this->info('There was a problem creating webpack mix file');
        }
    }
}
