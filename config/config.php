<?php
// コンテキストパスディレクトリ
const BASE_DIR = __DIR__ . '/../';
const LOG_DIR  = BASE_DIR . 'logs/';
// リスト
const LIST_PATH = BASE_DIR . 'list.txt';

// 対象ソースディレクトリ
const TARGET_DIR = '/var/www/';

/* 抽出(extract) */
// 抽出ファイルの保存ディレクトリ
const EXTRACT_DIR = BASE_DIR . '/extract/';
//const EXTRACT_ESCAPE_PATH = __DIR__ . '/_extract_old/';

/* 配置(put) */
const BACKUP_DIR = BASE_DIR . '/backup/';

const DATETIME_FORMAT = 'Ymd_Hi_s';
const OVERWRITE_SEPARATE = 'Overwrite:';
const ADD_SEPARATE = 'Add:';
