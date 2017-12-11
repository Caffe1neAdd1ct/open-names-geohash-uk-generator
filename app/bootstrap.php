<?php

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Console\Helper\ProgressBar;
use Slim\PDO\Database;

/* @var $app Silly\Application */
/* @var $container DI\Container */
$container = $app->getContainer();

/**
 * Config Loader
 */
$container->set('config', function($container) {
    return Yaml::parseFile(__DIR__ . '/config/config.yaml');
});

/**
 * DB Connection
 */
$container->set(Database::class, function() use ($container) {
    
    $dbConfig = $container->get('config')['db'];
    
    $dns = $dbConfig['driver'] . 
        ':host=' . $dbConfig['host'] . 
        ';dbname=' . $dbConfig['schema'] . 
        ';charset=' . $dbConfig['charset'] . 
        ';collation=' . $dbConfig['collation'];
    
    return new Database($dns, $dbConfig['user'], $dbConfig['pass'], (array) $dbConfig['options']);
});

/**
 * Cli Progress Bar
 */
$container->set(ProgressBar::class, function() use ($container)
{
    $progress = new ProgressBar($container->get(Symfony\Component\Console\Output\ConsoleOutput::class), 1);
    $progress->setFormat(sprintf('%s item: <info>%%item%%</info>', $progress->getFormatDefinition('debug')));
    $progress->setBarCharacter('<fg=green>⚬</>');
    $progress->setEmptyBarCharacter("<fg=red>⚬</>");
    $progress->setProgressCharacter("<fg=green>➤</>");
    $progress->setFormat("<fg=white;bg=cyan> %status:-45s%</>\n%current%/%max% [%bar%] %percent:3s%%\n  %estimated:-20s%  %memory:20s%");
    $progress->setMessage("Starting up the cogs and wheels", 'status');
    
    return $progress;
});


/**
 * CSV Reader
 */


/**
 * CSV Writer
 */

/**
 * PHP Coor Lib
 */

