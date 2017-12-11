<?php

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

require_once __DIR__ . '/vendor/autoload.php';

$app = new Silly\Edition\PhpDi\Application();

require_once __DIR__ . '/app/bootstrap.php';





$app->command('run', function (OutputInterface $output) use ($app) {
    
    var_dump($app->getContainer()->get('config'));
    
    $output->writeln('Starting run command.');
    // create a new progress bar (50 units)
    $progress = new ProgressBar($output, 50);
$progress->setFormat(sprintf('%s item: <info>%%item%%</info>', 
$progress->getFormatDefinition('debug'))); // the new format
$progress->setBarCharacter('<fg=green>⚬</>');
$progress->setEmptyBarCharacter("<fg=red>⚬</>");
$progress->setProgressCharacter("<fg=green>➤</>");
$progress->setFormat(
    "<fg=white;bg=cyan> %status:-45s%</>\n%current%/%max% [%bar%] %percent:3s%%\n  %estimated:-20s%  %memory:20s%"
);
    // start and displays the progress bar
    $progress->setMessage("Starting...", 'status');
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