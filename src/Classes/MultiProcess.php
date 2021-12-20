<?php


namespace SOS\MultiProcess\Classes;


use Symfony\Component\Process\Process;

/**
 * Class MultiProcess
 *
 * @author karam mustafa
 * @package SOS\MultiProcess\Classes
 */
class MultiProcess
{

    /**
     *
     * @author karam mustafa
     * @var
     */
    private $tasks;
    /**
     *
     * @author karam mustafa
     * @var
     */
    private $options = [
        'timeOut' => 60,
        'ideTimeOut' => 60,
        'workingDirectory' => null,
        'enableOutput' => true,
        'processTime' => 3,
    ];

    /**
     *
     * @author karam mustafa
     * @var array
     */
    private $processing = [];
    /**
     *
     * @author karam mustafa
     * @var int
     */
    private $processCount = 3;
    /**
     *
     * @author karam mustafa
     * @var int
     */
    private $waitingState = 1;
    /**
     *
     * @author karam mustafa
     * @var int
     */
    private $processingState = 2;
    /**
     *
     * @author karam mustafa
     * @var int
     */
    private $completedState = 3;
    /**
     *
     * @author karam mustafa
     * @var string
     */
    private $stateKey = 'state';
    /**
     *
     * @author karam mustafa
     * @var string
     */
    private $commandKey = 'command';

    /**
     * @return string
     * @author karam mustaf
     */
    public function getCommandKey()
    {
        return $this->commandKey;
    }

    /**
     * @param  string  $commandKey
     *
     * @return MultiProcess
     * @author karam mustaf
     */
    public function setCommandKey($commandKey)
    {
        $this->commandKey = $commandKey;

        return $this;
    }

    /**
     * @return mixed
     * @author karam mustaf
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param  mixed  $tasks
     *
     * @return MultiProcess
     * @author karam mustaf
     */
    public function setTasks(...$tasks)
    {
        foreach ($tasks as $task) {
            $scheduleTask = [];
            $scheduleTask['command'] = $task;
            $scheduleTask[$this->stateKey] = $this->waitingState;
            $this->tasks[] = $scheduleTask;
        }
        return $this;
    }

    /**
     * @param $key
     *
     * @return mixed
     * @author karam mustaf
     */
    public function getOptions($key)
    {
        return isset($this->options[$key]) ? $this->options[$key] : $this->options;
    }

    /**
     * @param  mixed  $options
     *
     * @author karam mustaf
     */
    public function setOptions($options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * display message depending on symfony returned type.
     *
     * @param $type
     * @param $buffer
     *
     * @author karam mustafa
     */
    public function displayOutputMessage($type, $buffer)
    {
        if (Process::ERR === $type) {
            echo 'ERROR >> '.$buffer;
        } else {
            echo 'SUCCESS >> '.$buffer;
        }
    }


    /**
     * this function will execute run function in symfony component
     * the function will check if we must display the error or the
     * response status from the executed functions from the symfony classes.
     *
     * @author karam mustafa
     */
    public function run()
    {
        $callback = function (Process $process) {
            return $process->run(function ($type, $buffer) {

                // if we enable the output, then display this message depending on it type.
                if ($this->getOptions('enableOutput')) {
                    $this->displayOutputMessage($type, $buffer);
                }
            });
        };

        $this->process($callback);

        $this->resolveNotRunningProcess($callback);
    }


    /**
     * start all process.
     *
     * @author karam mustafa
     */
    public function start()
    {
        // define the callback function.
        $callback = function (Process $process) {
            return $process->start();
        };

        $this->process($callback);

        $this->resolveNotRunningProcess($callback);
    }


    /**
     * this function will set the require config to a symfony process component.
     * and run what a callback will execute.
     *
     * @param $callback
     *
     * @author karam mustafa
     */
    private function process($callback)
    {
        while ($task = $this->checkIfCanProcess()) {

            $process = Process::fromShellCommandline($task[$this->getCommandKey()])
                ->enableOutput()
                ->setTimeout($this->getOptions('timeOut'))
                ->setIdleTimeout($this->getOptions('ideTimeOut'))
                ->setWorkingDirectory(base_path());

            // Add the process to the processing property
            $this->processing[] = $process;

            // run the given callback from the process argument
            // this callback could be a start or run function in symfony component
            // or might be any callback that accept Process parameter as a dependency.
            $callback($process);
        }
    }


    /**
     * this function will check if the entire process is was not finished yet
     * if there are any process that waiting to process, run this process
     * and remove it from processing array
     * then convert this task status to finish.
     *
     * @param $callback
     *
     * @author karam mustafa
     */
    private function resolveNotRunningProcess($callback)
    {
        while (count($this->processing) || !$this->isFinished()) {
            foreach ($this->processing as $i => $runningProcess) {
                if (!$runningProcess->isRunning()) {

                    unset($this->processing[$i]);

                    $this->process(function (Process $process) use ($callback) {
                        return $callback($process);
                    });

                    $this->finishTask($i);
                }
            }
            sleep($this->getOptions('processTime'));
        }
    }

    /**
     * after each task that processed in process function.
     * we will find the next task that have a waiting status.
     * and convert it status to a processing.
     *
     * @return null
     * @author karam mustafa
     */
    private function next()
    {
        foreach ($this->tasks as $i => $task) {
            if ($task[$this->stateKey] == $this->waitingState) {
                $this->tasks[$i][$this->stateKey] = $this->processingState;
                return $task;
            }
        }

        return null;
    }


    /**
     * convert task state to completed
     *
     * @param $key
     *
     * @author karam mustafa
     */
    private function finishTask($key)
    {
        if (isset($this->tasks[$key])) {
            $this->tasks[$key]['state'] = $this->completedState;
        }
    }

    /**
     * check if the all processes are complete.
     *
     * @return bool
     * @author karam mustafa
     */
    public function isFinished()
    {
        foreach ($this->tasks as $task) {
            if ($task['state'] !== $this->completedState) {
                return false;
            }
        }
        return true;
    }


    /**
     * check if there is a next task, or we are finish the all processes.
     *
     * @return bool|null
     * @author karam mustafa
     */
    private function checkIfCanProcess()
    {
        $task = $this->next();
        return (count($this->processing) < $this->processCount) && $task
            ? $task
            : false;
    }

}
