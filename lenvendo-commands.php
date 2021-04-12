#!/usr/bin/env php
<?php

use Lenvendo\ConsoleCommands\Console\Console;
use Lenvendo\ConsoleCommands\Console\Input;

require __DIR__.'/vendor/autoload.php';

$console = new Console(new Input());

$status = $console->handle();

//$console->terminate($status);