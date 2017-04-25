<?php

namespace Theintz\PhpDaemon;

use Theintz\PhpDaemon\Worker\Call;

interface IWorkerVia
{
    /**
     * Puts the message on the queue
     * @param $message_type
     * @param $message
     * @return boolean
     */
    public function put(Call $message);

    /**
     * Retrieves a message from the queue
     *
     * @param      $desired_type
     * @param bool $blocking
     * @return bool|Call
     */
    public function get($desired_type, $blocking = false);

    /**
     * Handle an Error
     *
     * @param     $error
     * @param int $try
     * @return mixed
     */
    public function error($error, $try=1);

    /**
     * The state of the queue -- The number of pending messages, memory consumption, errors, etc.
     * @return Array with some subset of these keys: messages, memory_allocation, error_count
     */
    public function state();

    /**
     * Drop the single message
     * @return void
     */
    public function drop($call_id);

    /**
     * Drop any pending messages in the queue
     * @return void
     */
    public function purge();

    /**
     * Remove and release any resources consumed by this Via. For SysV, this means removing the SHM and MQ resources.
     * In other cases, a blank implementation would also be fine: We don't want to drop a logical queue in RabbitMQ for example just because we're shutting down the listener.
     * @return mixed
     */
    public function release();
}