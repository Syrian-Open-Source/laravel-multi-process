<?php


namespace SOS\MultiProcess\Facades;


use Illuminate\Support\Facades\Facade;
use SOS\MultiProcess\Classes\MultiProcess;

/**
 * @method MultiProcess setTasks( ...$args)
 * @method MultiProcess start($callback)
 * @method MultiProcess run($callback)
 * @method MultiProcess runPHP($callback)
 * @method MultiProcess setOptions($options)
 */
class MultiProcessFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MultiProcessFacade';
    }
}
