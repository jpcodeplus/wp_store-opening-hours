<?php

namespace CPM;

class Logger {
    private $logFile;
    private $initiated = false;

    public function __construct($file) {
        $this->logFile = $file;
        $this->createFileIfNotExists();
    }

    private function createFileIfNotExists() {
        if (!file_exists($this->logFile)) {
            $fileHandle = fopen($this->logFile, 'w') or die('Cannot create file: '.$this->logFile);
            fclose($fileHandle);
        }
    }

    private function initiateFile() {
        $fileHandle = fopen($this->logFile, 'a') or die('Cannot open file: '.$this->logFile);
        fwrite($fileHandle, "- Log at ".date('Y-m-d H:i:s')." \n");
        fclose($fileHandle);
        $this->initiated = true;
    }

    public function write($message) {
        if (!$this->initiated) {
            $this->initiateFile();
        }
        $fileHandle = fopen($this->logFile, 'a') or die('Cannot open file: '.$this->logFile);
        fwrite($fileHandle, $message."\n-----\n");
        fclose($fileHandle);
    }
}