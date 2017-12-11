<?php

namespace App\Command;

/**
 * Run all commands
 *
 * @author Kevin Andrews <kevin@zvps.uk>
 */
class Run
{
    public function __invoke()
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
