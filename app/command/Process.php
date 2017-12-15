<?php

namespace App\Command;

use App\Command\Contract\Base;
use App\Workflow\OpenNameImport;

/**
 * Processes the open names data into long/lat and geohash formats
 *
 * @author Kevin Andrews <kevin@zvps.uk>
 */
class Process extends Base
{
    public function invoke(...$args) {
        
        $this->progress->start(4);
        $this->message('Locating csv files...');
        
        $config = $this->getConfig('process');
        $sourceDir = realpath(APP_DIR . $config['source']);
        $pdo = $this->container->get(\Slim\PDO\Database::class);
        
        if(!$sourceDir) {
            $this->message('Source folder missing: ' . APP_DIR . $config['source']);
            exit(1);
        }
        
        $sourceFiles = new \GlobIterator($sourceDir . '/*.csv', \FilesystemIterator::KEY_AS_FILENAME);
        $fileCount = count($sourceFiles);
        
        if(!$fileCount) {
            $this->message('No csv files found in ' . $sourceDir);
            exit(1);
        }
        
        $this->message('Starting to process ' . $fileCount . ' csv files.');
        $this->progress->start($fileCount + 4);
        $this->progress->finish();
        
        foreach ($sourceFiles as $file) {
            $output = [];
            $reader = new \Port\Csv\CsvReader($file->openFile('r'));
            $workflow = new OpenNameImport($this->container, $reader);
            $workflow->addWriter(new \Port\Writer\ArrayWriter($output));
            $workflow->addWriter(new \Port\Pdo\PdoWriter($this->container->get(\Slim\PDO\Database::class), 'postcodes'));
            $workflow->process();
            $this->progress->advance();
        }
        
    }
}
