<?php

namespace App\Command;

use \Psr\Log\LoggerInterface;
use \Symfony\Component\Console\Helper\ProgressBar;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;

/**
 * Run all commands
 *
 * @author Kevin Andrews <kevin@zvps.uk>
 */
class Run
{

    /**
     * 
     * @param Symfony\Component\Console\Output\ConsoleOutput $output
     * @param \Monolog\Logger $logger
     * @param \Symfony\Component\Console\Helper\ProgressBar $progress
     */
    public function __invoke(OutputInterface $output, LoggerInterface $logger, ProgressBar $progress)
    {
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
    }
    
}
