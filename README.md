# extract-file
ローカルバッチ処理用のファイル抽出＆配置

## TL;DR
list.txtに基づいてファイルを抽出・配置・復元する。

## config.php
list.txtに記述されたファイルを下記で設定する「対象ディレクトリ」に対して処理をする。
1. 対象ディレクトリから extract ディレクトリに抽出
2. extract ディレクトリから対象ディレクトリへファイルを配置
3. 2.を実行時に作成したバックアップから復元
```
const TARGET_DIR = '/var/html/src/';
```

## Why run

```
#extract by list file
php extract.php

#put extract file by list file
php put.php

#restore backup file. by list file
///
```

## TODO
復元機能実装
再帰削除処理をfail-safeに作成