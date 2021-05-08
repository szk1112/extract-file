<?php

use App\Lib\FileIterator;

require_once __DIR__ . '/bootstrap.php';

const FILE_PATH = __DIR__ . '/test.txt';

$process = new Main();

$process();

class Main
{
    /**
     * @return bool
     */
    public function __invoke()
    {
        echo FILE_PATH;
        $lines = new FileIterator(FILE_PATH);
        foreach($lines as $line){
            echo $line;
        }
//        $flg = copy('test.txt', 'test2.txt');
//        if ($flg) {
//            echo "コピー成功です";
//        } else {
//            echo "コピー失敗です";
//        }
        return true;
    }
}
