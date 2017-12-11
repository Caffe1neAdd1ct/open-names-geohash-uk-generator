<?php

namespace App\Command;

/**
 * Extracts the fetched copy of open names data
 *
 * @author Kevin Andrews <kevin@zvps.uk>
 */
class Extract extends Base
{   
    public function __invoke($file = false)
    {
        var_dump($this->container->get('config'));
    }
}
