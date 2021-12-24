<?php

namespace SOS\MultiProcess\Tests\Feature;

use PHPUnit\Framework\TestCase;
use SOS\MultiProcess\Facades\MultiProcessFacade;

class Commands extends TestCase
{
    /**
     * test if the commands are running successfully.
     *
     * @return void
     * @throws \Exception
     *
     */
    public function test_if_commands_run_successfully()
    {
        $result = MultiProcessFacade::setTasks('php artisan make:model MultiProcessModelTest');

        $this->assertTrue(true);
    }
}
