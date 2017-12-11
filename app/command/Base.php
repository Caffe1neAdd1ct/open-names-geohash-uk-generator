<?php

namespace App\Command;

use \Psr\Log\LoggerInterface;
use \Symfony\Component\Console\Helper\ProgressBar;
use \Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Base functionality for commands
 *
 * @author Kevin Andrews <kevin@zvps.uk>
 */
class Base
{
    /**
     * @var type 
     */
    protected $container;
    /**
     * @var Symfony\Component\Console\Output\ConsoleOutput 
     */
    protected $output;
    /**
     * @var \Monolog\Logger 
     */
    protected $logger;
    /**
     * @var \Symfony\Component\Console\Helper\ProgressBar 
     */
    protected $progress;
    
    public function __construct(\DI\Container $container, ConsoleOutput $output, LoggerInterface $logger, ProgressBar $progress)
    {
        $this->container = $container;
        $this->output = $output;
        $this->logger = $logger;
        $this->progress = $progress;
    }
}
