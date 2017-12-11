#!/usr/bin/env php
<?php

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silly\Edition\PhpDi\Application();

require_once __DIR__ . '/app/bootstrap.php';

/**
 * Run Command
 * php index.php run
 */
$app->command('run', function (OutputInterface $output, Psr\Log\LoggerInterface $logger, ProgressBar $progress) use ($app) {
    
    
    /* @var $dbConnection Slim\PDO\Database */
    $dbConnection = $app->getContainer()->get(Slim\PDO\Database::class);

    $output->writeln('Starting run command.');
    // create a new progress bar (50 units)
    
    $progress->start();

    $i = 0;
    while ($i++ < 50) {
        // ... do some work

        sleep(1);
        // advance the progress bar 1 unit
        $progress->advance();

        // you can also advance the progress bar by more than 1 unit
        $progress->setMessage("Processing the datas..", 'status');
    }

    // ensure that the progress bar is at 100%
    $progress->finish();

    $output->writeln('Finished run command.');
});

$app->run();
