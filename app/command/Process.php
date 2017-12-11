<?php

namespace App\Command;

/**
 * Processes the open names data into long/lat and geohash formats
 *
 * @author Kevin Andrews <kevin@zvps.uk>
 */
class Process extends Base
{
    public function __invoke() {
        $this->progress->start(6);
        $this->message('Locating csv files...');
        $config = $this->getConfig('process');
        
        if(!realpath(APP_DIR . $config['source'])) {
            $this;
        }
    }
}
