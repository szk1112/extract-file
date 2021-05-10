<?php

use App\Lib\FileIterator;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require_once __DIR__ . '/bootstrap.php';

/**
 * @description LIST_PATHを元に抽出(extract)したファイルをバックアップ後、配置(put)する。
 *              リストアは未実装
 */

$process = new Put();
if (!file_exists(EXTRACT_DIR)) {
    echoLine('not found extract directory.');
    exit();
}
echoLine('Start put file...');
try {
    if ($process()) {
        echoLine('All done.');
    } else {
        echoLine('...Failed, An error has occurred.');
    }
} catch (\Exception $e) {
    echoLine($e->getMessage());
}

class Put
{

    public $hasError = false;

    /** @var Logger */
    public $logger;

    public function __construct()
    {
        $this->initialize();
        $this->logger->info('put start...');
    }

    public function __destruct()
    {
        $this->logger->info('...put end');
    }

    private function initialize()
    {
        //第4引数で末尾の付加情報が空の場合無視([][]削除)する
        $formatter = new LineFormatter(null, null, true, true);
        makeDirectory(LOG_DIR);
        $stream    = new StreamHandler(LOG_DIR.sprintf('put_%s.log',getUniqueLogKey()), Logger::INFO);
        $stream->setFormatter($formatter);
        $this->logger = new Logger('put');
        $this->logger->pushHandler($stream);
    }

    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        $lines = new FileIterator(LIST_PATH);
        foreach ($lines as $line) {
            $text    = normalize($line);
            $putTo = TARGET_DIR . $text;
            $putFrom = EXTRACT_DIR . $text;
            if (!file_exists($putFrom)) {
                $this->logger->error('not found put file.');
                echoLine('not found put file.');
                return false;
            }
            $backupFile = BACKUP_DIR . $text;
            try {
                // 上書きになるか、リストアで使用予定
                $isOverwrite = $this->backUp($putTo, $backupFile);
            } catch (\Exception $e) {
                echoLine('backup failed.');
                $this->logger->error($e->getMessage());
                return false;
            }
            // ファイル配置処理
            makeDirectory($putTo);
            $result = copy($putFrom, $putTo);
            if (!$result) {
                $this->hasError = true;
                break;
            }
            $info = $isOverwrite ? OVERWRITE_SEPARATE : ADD_SEPARATE;
            $this->logger->info($info . $text);
        }
        $this->logger->info('done.');
        return !$this->hasError;
    }

    /**
     * @throws Exception
     */
    public function backUp($oldFile, $backupFile): bool
    {
        // バックアップ対象ファイルが存在するか
        if (file_exists($oldFile)) {
            $isOverwrite = true;
            if (makeDirectory($backupFile)) {
                $result = copy($oldFile, $backupFile);
                if (!$result) {
                    throw new \Exception('failed copy file:' . $backupFile);
                }
            } else {
                throw new \Exception('failed make directory:' . $backupFile);
            }
        } else {
            // バックアップ対象ファイルが存在しなければinfoのみ出力
            $this->logger->info('file not exist:' . $oldFile);
            $isOverwrite = false;
        }
        return $isOverwrite;
    }

}
