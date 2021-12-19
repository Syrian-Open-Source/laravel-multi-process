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
        $this->options = array_merge($this->options , $options);
    }

    /**
     * todo description
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
     * todo description
     *
     * @author karam mustafa
     */
    public function run()
    {
        $callback = function (Process $process) {
            return $process->run(function ($type, $buffer) {
                if ($this->getOptions('enableOutput')) {
                    $this->displayOutputMessage($type, $buffer);
                }
            });
        };

        $this->process($callback);

        $this->checkAvailability($callback);
    }


    /**
     * todo description
     *
     * @author karam mustafa
     */
    public function start()
    {
        $callback = function (Process $process) {
            return $process->start();
        };

        $this->process($callback);

        $this->checkAvailability($callback);
    }


    /**
     * todo description
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

            $this->processing[] = $process;

            $callback($process);
        }
    }


    /**
     * todo description
     *
     * @param $callback
     *
     * @author karam mustafa
     */
    private function checkAvailability($callback)
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
     * todo description
     *
     * @return |null
     * @author karam mustafa
     */
    private function getNextTask()
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
     * todo description
     *
     * @param $key
     *
     * @author karam mustafa
     */
    private function finishTask($key)
    {
        $this->tasks[$key]['state'] = $this->completedState;
    }

    /**
     * todo description
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
     * todo description
     *
     * @return bool|null
     * @author karam mustafa
     */
    private function checkIfCanProcess()
    {
        $task = $this->getNextTask();
        return (count($this->processing) < $this->processCount) && $task
            ? $task
            : false;
    }

}
