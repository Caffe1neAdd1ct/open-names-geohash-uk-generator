<?php

namespace App\Command;

use App\Command\Contract\Base;

/**
 * Extracts the fetched copy of open names data
 *
 * @author Kevin Andrews <kevin@zvps.uk>
 */
class Extract extends Base
{
    /**
     * 
     * @param string|boolean $file
     * @param array $args
     */
    public function invoke($file = false, ...$args)
    {
        $this->progress->start(6);
        $this->message('Locating data file...');
        $config = $this->getConfig('extract');
        
        $this->message('Attempting to load file from param...');
        
        $fileName = $file;
        $filePath = realpath(APP_DIR . $config['path']) . DS . $file;
        $fileExists = file_exists($filePath);
        
        if(!$file || !$filePath || !$fileExists) {
            $this->progress->advance(-1);
            $this->message('Attempting to load file from config.');
            $fileName = $config['file'];
            $filePath = realpath(APP_DIR . $config['path']) . DS . $fileName;
            $fileExists = file_exists($filePath);
        }
        
        if (!$filePath || !$fileExists) {
            $this->message('File "' . $fileExists . '" does not exist.');
            exit(1);
        }
        
        $this->message('Opening zip file ' . $filePath . '.');

        $zip = new \ZipArchive();
        
        if(true !== $zip->open($filePath, \ZipArchive::CHECKCONS)) {
            $this->message('File "' . $filePath . '" not a valid openable .zip file.');
            exit(1);
        }
        
        $this->message('Extracting file ' . $filePath . '.');
        
        if(!$zip->extractTo(APP_DIR . $config['to'])) {
            $this->message('File "' . $filePath . '" failed to extract.');
            exit(1);
        }
        
        $this->message('Moving csv files.');
        
        $files = scandir(realpath(APP_DIR . $config['to'] . DS . 'DATA'));
        foreach($files as $fname) {
            if($fname != '.' && $fname != '..') {
                rename(APP_DIR . $config['to'] . 'DATA' . DS . $fname, APP_DIR . $config['move'] . $fname);
            }
        }
        
        $this->message('Cleaning up tmp directory.');
        $this->deleteFiles(APP_DIR . $config['to']);
        
        $this->message('Extraction complete!');
        $this->progress->clear();
    }
    
    /**
     * Warning this will recursively delete a directory!
     * @param string $dir
     */
    public function deleteFiles($dir, $original=true)
    {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                $this->deleteFiles($file, false);
            } else {
                if($file !== ".gitkeep" && $file !== '.' && $file !== '..') {
                    unlink($file);
                }
            }
        }
        
        if(!empty($dir) && $original === false) {
            rmdir($dir);
        }
    }

}
