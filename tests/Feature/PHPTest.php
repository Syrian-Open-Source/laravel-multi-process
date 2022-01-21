<?php

namespace SOS\MultiProcess\Tests\Feature;


use SOS\MultiProcess\Classes\MultiProcess;
use SOS\MultiProcess\Tests\BaseTest;

class PHPTest extends BaseTest
{

    /**
     * test if the php codes are running successfully.
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
                echo 'process 2';
            },
            function () {
                echo 'process 3';
            }
        );

        foreach ($processor->runPHP()->getTasks() as $task) {
            $this->assertEquals($task['state'], $completedState);
        }

    }
}
