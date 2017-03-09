<?php
mb_internal_encoding("UTF-8");


// 送信元アドレス
$mailfrom="From:" .mb_encode_mimeheader("xxxxxxxxxxx") ."<noreply@example.com>";

// メール件名
$mailSubject = "xxxxxxxxxx";

// メール本文
$mailBody = <<<EOD
資料請求・お問い合わせがありました。


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


EOD;

// 送信先アドレス
$mailTo = "mori@babagump.co.jp";
