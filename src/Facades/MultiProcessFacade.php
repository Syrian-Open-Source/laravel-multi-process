<?php


namespace SOS\MultiProcess\Facades;


use Illuminate\Support\Facades\Facade;

class MultiProcessFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MultiProcessFacade';
    }
}
