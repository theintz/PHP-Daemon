#!/usr/bin/php
<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../../src/error_handlers.php';

use Examples\PrimeNumbers;

// The run() method will start the daemon loop.
PrimeNumbers\PrimeDaemon::getInstance()->run();
