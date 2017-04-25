<?php

namespace Examples\Tasks;

use Theintz\PhpDaemon\ITask;

/**
 * Demonstrate using a Core_ITask object to create a more complex task
 * This won't actually do anything but you get the idea
 *
 * @author Shane Harter
 * @todo Create a plausible demo of a complex task that implements \Theintz\PhpDaemon\ITask
 */
class BigTask implements ITask
{
    /**
     * A handle to the Daemon object
     * @var \Theintz\PhpDaemon\Daemon|ParallelTasks
     */
    private $daemon = null;

    /**
     * @var int
     */
    private $sleep_duration;

    /**
     * @var string
     */
    private $wakeup_message;

    public function __construct($sleep_duration, $wakeup_message = '') {
        $this->sleep_duration = $sleep_duration;
        $this->wakeup_message = $wakeup_message;
    }

    /**
     * Called on Construct or Init
     * @return void
     */
    public function setup()
    {
        $this->daemon = ParallelTasks::getInstance();
    }

    /**
     * Called on Destruct
     * @return void
     */
    public function teardown()
    {
        // Satisfy Interface
    }

    /**
     * This is called after setup() returns
     * @return void
     */
    public function start()
    {
       // This is just going to sleep a really long time.
       // I'll replace this with a better demo in a future version.
       // The idea is that the easiest way to parallelize some code in your daemon is to pass a closure or callback to the task() method.
       // But if you have a complex task that can get ugly and difficult to read and understand. In those cases, you can implement
       // a Core_ITask object like this one.

       $this->daemon->log("Starting BigTask...");
       sleep($this->sleep_duration);
       if ($this->wakeup_message)
           $this->daemon->log($this->wakeup_message);
    }

    /**
     * Give your ITask object a group name so the ProcessManager can identify and group processes. Or return Null
     * to just use the current __class__ name.
     *
     * @return string
     */
    public function group() {
        // TODO: Implement group() method.
    }
}
