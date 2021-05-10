<?php
if (!function_exists('makeDirectory')) {
    function makeDirectory($toFilePath): bool
    {
        // 存在チェック
        if (!empty($toFilePath) && is_readable($toFilePath)) {
            return true;
        } else {
            // 最後がスラッシュで終わる場合はそのままディレクトリ作成
            if (substr($toFilePath, -1) === '/') {
                return mkdir($toFilePath, 0777, true);
            } else {
                $path    = pathinfo($toFilePath);
                $dirPath = $path["dirname"];
                if (!is_readable($dirPath)) {
                    return mkdir($dirPath, 0777, true);
                }
                return true;
            }
        }
    }
}