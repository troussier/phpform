<?php
mb_internal_encoding("UTF-8");


// 送信元アドレス
$mailfrom="From:" .mb_encode_mimeheader("山口工務店") ."<noreply@yamaguchi-co.co.jp>";

// メール件名
$mailSubject = "【山口工務店】資料請求・お問い合わせを受け付けました。【自動返信】";

// メール本文
$mailBody = <<<EOD
こんにちは、山口工務店です。
資料請求・お問い合わせをありがとうございます。

追って担当者から連絡いたします。
今しばらくお待ち下さい。


[ご記入内容]

■お名前
$_POST[name__i]

■年齢
$_POST[age__i]

■郵便番号
$_POST[zip__i]

■ご住所
$_POST[address__i]

■お電話番号
$_POST[tel__i]

■メールアドレス
$_POST[mail__i]

■サイトを知ったきっかけ
$_POST[know__i]

■ご計画予定は？
$_POST[plan__i]

■イベント・見学会の参加
$_POST[event__i]

■ショールームのパンフレット
$_POST[pamphlet__i]

■リフォーム資料
$_POST[reform__i]

■お問い合わせ内容
$_POST[content__i]



山口工務店
http://www.yamaguchi-co.co.jp/


EOD;

// 送信先アドレス
//$mailTo = "mori@babagump.co.jp";
$mailTo = $_POST[mail__i];
