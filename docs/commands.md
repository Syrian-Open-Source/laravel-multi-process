Usage
--------
* Define multiple process and execute them by start function.

```shell
    $proceses = MultiProcessFacadeAlias::setTasks(
        "php artisan make:model modelName",
        "php artisan make:model ControllerName",
        // and you can define unlimited commands
    );
    $processor->start();

```
* Define multiple process and execute them by run function.

```shell

    $proceses = MultiProcessFacadeAlias::setTasks(
        "php artisan make:model modelName",
        "php artisan make:model ControllerName",
        // and you can define unlimited commands
    );

    // run function will allows you to get the output from the execution process.
    $processor->run();

```

