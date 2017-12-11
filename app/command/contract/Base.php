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
    
    protected final function getConfig($section=false)
    {
        if($section) {
            return $this->container->get('config')[$section];
        }
        
        return $this->container->get('config');
    }
    
    public final function __construct(\DI\Container $container, ConsoleOutput $output, LoggerInterface $logger, ProgressBar $progress)
    {
        $this->container = $container;
        $this->output = $output;
        $this->logger = $logger;
        $this->progress = $progress;
    }
    
    public final function __invoke(...$args)
    {
        var_dump($args);
        $this->output->writeln('__invoke ran');
//        self::start();
        return call_user_func_array([$this, 'invoke'], $args[0]);
    }
    
    public final function start()
    {
        $this->output->writeln('start ran');
        $this->progress->start();
    }
    
    public final function __destruct()
    {
        $this->progress->finish();
    }
}
