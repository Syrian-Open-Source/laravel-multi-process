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
     * publish files
     *
     * @author karam mustafa
     */
    protected function publishesPackages()
    {
        $this->publishes([
            __DIR__.'/../Config/multi_process.php' => config_path('multi_process.php'),
        ], 'multi-process-config');
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
