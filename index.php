#!/usr/bin/env php
<?php

/** @var string Constant pointing to the application parent directory */
define('APP_DIR', __DIR__);
/** @var string Short replacement for the DIRECTORY_SEPARATOR constant */
define('DS', DIRECTORY_SEPARATOR);

require_once __DIR__ . '/vendor/autoload.php';
$app = new Silly\Edition\PhpDi\Application();
require_once __DIR__ . '/app/bootstrap.php';

/**
 * Run Command
 * php index.php run
 */
$app->command('extract [args]*', 'App\Command\Extract');
$app->command('process [args]*', 'App\Command\Process');

$app->run();
