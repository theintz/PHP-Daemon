#!/usr/bin/php
<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../../src/error_handlers.php';

use Examples\LongPoll;

// The run() method will start the daemon event loop.
LongPoll\Poller::getInstance()->run();
