#!/usr/bin/php
<?php
require_once 'config.php';
require_once '../../src/error_handlers.php';

use Examples\PrimeNumbers;

// The run() method will start the daemon loop.
PrimeNumbers\PrimeDaemon::getInstance()->run();