<?php


namespace SOS\LaravelMultiProcess\Interfaces;


use SOS\LaravelMultiProcess\Commands\InstallCommand;

class MultiProcessInterface
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
