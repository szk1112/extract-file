<?php

use App\Lib\FileIterator;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require_once __DIR__ . '/bootstrap.php';


$process = new Extract();

echoLine('Start extract file.');
if ($process()) {
    echoLine('All done.');
} else {
    echoLine('Failed, An error has occurred.');
}

class Extract
{

    public $hasError = false;

    /** @var Logger */
    public $logger;

    public function __construct()
    {
        $this->initialize();
    }

    private function initialize()
    {
        $formatter = new LineFormatter(null, null, true, true);
        makeDirectory(LOG_DIR);
        $stream    = new StreamHandler(LOG_DIR.sprintf('extract_%s.log',getUniqueLogKey()), Logger::INFO);
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
            $text = normalize($line);
            makeDirectory(EXTRACT_DIR);
            if (file_exists(TARGET_DIR . $text)) {
                if (makeDirectory(EXTRACT_DIR . $text)) {
                    $result = copy(TARGET_DIR . $text, EXTRACT_DIR . $text);
                } else {
                    $result = false;
                    $this->logger->error('failed make directory:' . EXTRACT_DIR . $text);
                }
            } else {
                $this->logger->info('file not found:' . TARGET_DIR . $text);
                continue;
            }
            if (!$result) {
                $this->logger->error('failed copy file:' . TARGET_DIR . $text);
                $this->hasError = true;
            }
            unset($result);
        }
        $this->logger->info('done.');
        return !$this->hasError;
    }



}
