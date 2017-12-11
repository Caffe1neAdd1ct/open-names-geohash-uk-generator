<?php

namespace App\Command\Contract;

/**
 *
 * @author Kevin Andrews <kevin@zvps.uk>
 */
interface InvokableCommand
{
    public function invoke(...$args);
}
