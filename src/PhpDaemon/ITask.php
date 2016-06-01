<?php

namespace Theintz\PhpDaemon;

/**
 * Objects that implement ITask can be passed directly to the Daemon::task() method. Simple tasks can be implemented as
 * a closure. But more complex tasks (or those that benefit from their own setup() and teardown() code) can be more cleanly
 * written as a ITask object.
 *
 * The setup() method in a ITask object is run in the newly-forked process created specifically for this task. You can
 * also create a Daemon::on(ON_FORK) event handler that can run any setup/auditing/tracing/etc code in the parent process.
 *
 * Note: An ON_FORK event will be dispatched every time a new task() is created -- whether that is explicitely by you, or implicitely
 * by the Worker API.
 */
interface ITask
{
    /**
     * Called on Construct or Init
     * @return void
     */
    public function setup();

    /**
     * Called on Destruct
     * @return void
     */
    public function teardown();

    /**
     * This is called after setup() returns
     * @return void
     */
    public function start();

    /**
     * Give your ITask object a group name so the ProcessManager can identify and group processes. Or return Null
     * to just use the current __class__ name.
     * @return string
     */
    public function group();
}