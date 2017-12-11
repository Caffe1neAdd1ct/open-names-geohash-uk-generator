<?php

/* @var $app Silly\Application */

/**
 * Config Loader
 */
$app->getContainer()->set('config', function() {
    return [
        'db_host' => 'localhost',
        'db_driver' => 'mysql',
        'db_user' => 'root',
        'db_pass' => 'letmein',
        'data_dir' => realpath(__DIR__ . '/../data')
        
    ];
});

/**
 * DB Connection
 */

/**
 * CSV Processor
 */

/**
 * PHP Loc Lib
 */

