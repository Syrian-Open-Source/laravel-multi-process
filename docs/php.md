Usage
--------
* Define multiple process and execute them by start function,
each task must be a callback function as you can see in the below example.

```shell
    $process = \SOS\MultiProcess\Facades\MultiProcessFacade::setTasks(
        function () {
            return \Illuminate\Support\Facades\DB::statement('delete from users where id = 5');
        }, function () {
            return \Illuminate\Support\Facades\DB::statement('delete from users where id = 6');
        }
    );
    $process->runPHP();
```
* Add options.

```shell

    // default options are in multi_process.php file.
    // you can change them from the file
    // or you can basicly added them from the setter function.
    $process = \SOS\MultiProcess\Facades\MultiProcessFacade::setTasks(
        "php artisan make:model modelName",
        "php artisan make:model ControllerName",
        // and you can define unlimited commands
    )->setOptions([
       'timeOut' => 60,
       'ideTimeOut' => 60,
       'enableOutput' => true,
       'processTime' => 3,

       // thorw exceprtion if any task was failed.
       'throwIfTaskNotSuccess' => false,
    );

    // run or start your tasks.
    $process->start();

```

