<?php

namespace App\Command\Contract;

use \Psr\Log\LoggerInterface;
use \Symfony\Component\Console\Helper\ProgressBar;
use \Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Base functionality for commands
 *
 * @author Kevin Andrews <kevin@zvps.uk>
 */
abstract class Base implements InvokableCommand
{
    /**
     * @var \DI\Container
     */
    protected $container;
    /**
     * @var \Symfony\Component\Console\Output\ConsoleOutput 
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

    /**
     * 
     * @param \DI\Container $container
     * @param ConsoleOutput $output
     * @param LoggerInterface $logger
     * @param ProgressBar $progress
     */
    public final function __construct(\DI\Container $container, ConsoleOutput $output, LoggerInterface $logger, ProgressBar $progress)
    {
        $this->container = $container;
        $this->output = $output;
        $this->logger = $logger;
        $this->progress = $progress;
    }
    
    /**
     * 
     * @param array $args
     * @return type
     */
    public final function __invoke(...$args)
    {
        $return = call_user_func_array([$this, 'invoke'], $args[0]);
        $this->progress->finish();
        return $return;
    }
    
    /**
     * 
     * @param string $section
     * @return array
     */
    protected final function getConfig($section=false)
    {
        if($section) {
            return $this->container->get('config')[$section];
        }
        
        return $this->container->get('config');
    }
    
    /**
     * 
     * @param type $text
     */
    protected function message($text = '')
    {
        $this->progress->setMessage($text, 'status');
        $this->progress->advance();
        $this->output->writeln(PHP_EOL);
    }
}
