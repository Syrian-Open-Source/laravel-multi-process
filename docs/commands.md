Usage
--------
* Define multiple process and execute them by start function.

```shell
    $process = \SOS\MultiProcess\Facades\MultiProcessFacade::setTasks(
        "php artisan make:model modelName",
        "php artisan make:model ControllerName",
        // and you can define unlimited commands
    );
    $process->start()
     // if ypu want to see the tasks log,
     //  you can fetch the tasks lists by calling the function
     ->getTasks();

```
* Define multiple process and execute them by run function.

```shell

    $process = \SOS\MultiProcess\Facades\MultiProcessFacade::setTasks(
        "php artisan make:model modelName",
        "php artisan make:model ControllerName",
        // and you can define unlimited commands
    );

    // run function will allows you to get the output from the execution process.
    $process->run()
     // if ypu want to see the tasks log,
     //  you can fetch the tasks lists by calling the function
     ->getTasks();

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
    $process->start()
     // if ypu want to see the tasks log,
     //  you can fetch the tasks lists by calling the function
     ->getTasks();

```
