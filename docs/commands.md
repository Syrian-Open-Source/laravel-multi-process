Usage
--------
* Define multiple process and execute them by start function.

```shell
    $proceses = MultiProcessFacadeAlias::setTasks(
        "php artisan make:model modelName",
        "php artisan make:model ControllerName",
        // and you can define unlimited commands
    );
    $proceses->start();

```
* Define multiple process and execute them by run function.

```shell

    $proceses = MultiProcessFacadeAlias::setTasks(
        "php artisan make:model modelName",
        "php artisan make:model ControllerName",
        // and you can define unlimited commands
    );

    // run function will allows you to get the output from the execution process.
    $proceses->run();

```
* Add options.

```shell

    // default options are in multi_process.php file.
    // you can change them from the file
    // or you can basicly added them from the setter function.
    $proceses = MultiProcessFacadeAlias::setTasks(
        "php artisan make:model modelName",
        "php artisan make:model ControllerName",
        // and you can define unlimited commands
    )->setOptions([
       'timeOut' => 60,
       'ideTimeOut' => 60,
       'enableOutput' => true,
       'processTime' => 3,
    );

    // run or start your tasks.
    $proceses->start();

```

