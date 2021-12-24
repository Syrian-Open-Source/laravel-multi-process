<?php

namespace SOS\MultiProcess\Tests\Feature;


use SOS\MultiProcess\Classes\MultiProcess;
use SOS\MultiProcess\Tests\BaseTest;

class CommandsTest extends BaseTest
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
        $completedState = 3;

        $processor = (new MultiProcess())->setTasks(
            "php artisan make:model MultiProcessTestModel",
            "php artisan make:model MultiProcessTestController"
        )->setOptions([
            'enableOutput' => false
        ]);

        foreach ($processor->start()->getTasks() as $task) {
            $this->assertEquals($task['state'], $completedState);

        }

    }
}
