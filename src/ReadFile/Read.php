<?php

namespace DemoGame\Zelda\ReadFile;

class Read
{
    public $file;

    public function __construct($file = null)
    {
        $this->file = $file;
    }

    public function read()
    {
        if (isset($this->file)) {
            $nameFile = sprintf('./src/ReadFile/%s', $this->file);
            $res = file_get_contents($nameFile, true);
            return $res;
        }
        return 'error, file not found';
    }

    public function divideTxt($nameFile)
    {
        $file = file(sprintf('./src/ReadFile/%s.txt', $nameFile));
        $parts = [];
        $part = [];
        foreach ($file as $line) {
            if (empty(trim($line))) {
                if (!empty($part)) {
                    $parts[] = $part;
                    $part = [];
                }
            } else {
                $part[] = $line;
            }
        }
        if (!empty($part)) {
            $parts[] = $part;
        }
        $res = [];
        foreach($parts as $part){
            $res[] = join($part);
        }

        return $res;
    }
}