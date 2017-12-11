#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silly\Edition\PhpDi\Application();

require_once __DIR__ . '/app/bootstrap.php';

/**
 * Run Command
 * php index.php run
 */
$app->command('run', 'App\Command\Run');

$app->run();
