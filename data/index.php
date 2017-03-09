<?php

// ダウンロードさせる元ファイル
$source = 'file.csv';
// 保存時のファイル名(デフォルト)
$filename = 'recruitdata.csv';

// HTTPヘッダ送信
header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=＼"{$filename}＼"");
// ファイルを読み込んで出力
readfile($source);

?>