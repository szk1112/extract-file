<?php


namespace App\Lib;


use BadFunctionCallException;
use Iterator;

class FileIterator  implements Iterator
{


    public $fp;
    private $line;

    public function __construct($path, $mode = 'r')
    {
        $this->fp = fopen($path, $mode);
        $this->line = fgets($this->fp);
    }

    public function __destruct() {
        @fclose($this->fp);
    }
    public function current() {
        return $this->line;
    }
    public function key() {
        throw new BadFunctionCallException();
    }
    public function next() {
        $this->line = fgets($this->fp);
        return $this->line;
    }
    public function rewind() {
        return rewind($this->fp);
    }
    public function valid() {
        return (!is_null($this->fp) && $this->line !== false);
    }

}