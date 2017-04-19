#!/usr/bin/php
<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../../src/error_handlers.php';

use Examples\Tasks;

// The run() method will start the daemon loop.
Tasks\ParallelTasks::getInstance()->run();
