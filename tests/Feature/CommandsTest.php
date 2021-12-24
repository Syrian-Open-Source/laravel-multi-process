<?php

namespace SOS\MultiProcess\Tests\Feature;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\TestCase;

class CommandsTest extends TestCase
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
        $s = PHP_OS == "Windows" || PHP_OS == "WINNT" ? "\\" : '/';

        $processor = \SOS\MultiProcess\Facades\MultiProcessFacade::setTasks(
            "php artisan make:model MultiProcessTestModel",
            "php artisan make:model MultiProcessTestController",
            )->setOptions([
            'enableOutput' => false
        ]);
        $processor->run();

        if (is_dir(app_path("Http{$s}Models"))) {
            $this->assertTrue(File::exists(app_path()."Http{$s}Models{$s}MultiProcessTestModel.php"));
        } else {
            $this->assertTrue(File::exists(app_path()."Http{$s}MultiProcessTestModel.php"));
        }

        $this->assertTrue(File::exists(app_path("Http{$s}Controllers{$s}MultiProcessTestController.php")));
    }
}
