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
    public function test_if_php_code_run_successfully()
    {
        $completedState = 3;

        $processor = (new MultiProcess())->setTasks(
            function () {
                echo 'process 1';
            },
            function () {
                echo 'process 1';
            },
            function () {
                echo 'process 1';
            }
        );

        foreach ($processor->start()->getTasks() as $task) {
            $this->assertEquals($task['state'], $completedState);
        }

    }
}
