#!/usr/bin/env php
<?php

define('APP_DIR', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

require_once __DIR__ . '/vendor/autoload.php';
$app = new Silly\Edition\PhpDi\Application();
require_once __DIR__ . '/app/bootstrap.php';

/**
 * Run Command
 * php index.php run
 */
$app->command('run [args]*', 'App\Command\Run');
$app->command('extract [args]*', 'App\Command\Extract');
$app->command('process [args]*', 'App\Command\Process');
$app->command('export [args]*', 'App\Command\Export');

$app->run();
