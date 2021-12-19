<?php


namespace SOS\MultiProcess\Providers;


use Illuminate\Support\ServiceProvider;
use SOS\MultiProcess\Classes\MultiProcess;
use SOS\MultiProcess\Commands\InstallCommand;

class MultiProcessServiceProviders extends ServiceProvider
{
    /**
     *
     *
     * @author karam mustafa
     */
    public function boot()
    {
        $this->publishesPackages();
        $this->resolveCommands();
        $this->registerFacades();
    }

    /**
     *
     *
     * @author karam mustafa
     */
    public function register()
    {
    }

    /**
     *
     */
    protected function registerFacades()
    {
        $this->app->singleton('MultiProcessFacade', function () {
            return new MultiProcess();
        });
    }

    /**
     * @desc publish files
     * @author karam mustafa
     */
    protected function publishesPackages()
    {

    }

    /**
     *
     *
     * @author karam mustafa
     */
    private function resolveCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
