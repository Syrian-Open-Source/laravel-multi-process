Usage
--------
* Define multiple process and execute them by start function,
each task must be a callback function as you can see in the below example.

```shell

    // if you are enable the output from the options
    // you can see the outputs are printed.
    $process = \SOS\MultiProcess\Facades\MultiProcessFacade::setTasks(
        function () {
            echo 'The first task to run';
        }, function () {
            echo 'The second task to run';
        }
    );
    $process->runPHP()
     // if ypu want to see the tasks log,
     //  you can fetch the tasks lists by calling the function
     ->getTasts();
```
* Add options.

```shell

    // default options are in multi_process.php file.
    // you can change them from the file
    // or you can basicly added them from the setter function.
    $process = \SOS\MultiProcess\Facades\MultiProcessFacade::setTasks(
        function () {
            echo 'The first task to run';
        }, function () {
            echo 'The second task to run';
        }
    ->setOptions([
       'timeOut' => 60,
       'ideTimeOut' => 60,
       'enableOutput' => true,
       'processTime' => 3,

       // thorw exceprtion if any task was failed.
       'throwIfTaskNotSuccess' => false,
    );

    // run or start your tasks.
    $process->runPHP()
    // if ypu want to see the tasks log,
    //  you can fetch the tasks lists by calling the function
    ->getTasts();
```

