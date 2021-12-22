<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    | This are the configs and options we passing to
    | the symfony process component. You can edit them from here
    | you can change them directly while you execute the code by setOption function.
    */
    'options' => [

        // the timeout time that symfony process component
        // trying to execute the each command.
        'timeOut' => 60,

        // the ide timeout time that symfony process component
        // trying to execute the each command.
        'ideTimeOut' => 60,

        // dump output if you are using run method to execute your tasks
        'enableOutput' => true,

        // The time in seconds that the package tries to perform the un executed tasks.
        'processTime' => 3,

    ],
];
