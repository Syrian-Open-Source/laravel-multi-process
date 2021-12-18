<?php


namespace SOS\MultiProcess\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{

    public $packageLink = 'https://github.com/syrian-open-source/laravel-multi-process';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'query-helper:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install all laravel-multi-process package dependencies';

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
        $this->info('<info> Install the dependencies was success</info>');

        if ($this->confirm('Would you like to show some love by starring the repo?', true)) {
            if (PHP_OS_FAMILY === 'Darwin') {
                exec("open $this->packageLink");
            }
            if (PHP_OS_FAMILY === 'Linux') {
                exec("xdg-open $this->packageLink");
            }
            if (PHP_OS_FAMILY === 'Windows') {
                exec("start $this->packageLink");
            }

            $this->line('Thank you!');
        }
    }
}
