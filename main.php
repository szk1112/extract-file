<?php

use App\Lib\File;

require_once __DIR__ . '/bootstrap.php';

$process = new Main();

$process();

class Main
{
    /**
     * @return bool
     */
    public function __invoke()
    {
        $fileService = new File();
        $flg = copy('test.txt', 'test2.txt');
        if ($flg) {
            echo "コピー成功です";
        } else {
            echo "コピー失敗です";
        }
        return true;
    }
}
