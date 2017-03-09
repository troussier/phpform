<?php

//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

// デフォルトのアクションキーは[enter]
$act = "enter";


function isValidInetAddress($data, $strict = false)
{
    $regex = $strict ? '/^([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})$/i' : '/^([*+!.&#$|\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})$/i';
    if (preg_match($regex, trim($data), $matches)) {
        return array($matches[1], $matches[2]);
    } else {
        return false;
    }
}



/* ------------------------------
 * 入力画面のボタン押下時チェック
 * ------------------------------*/

if ($_POST["act"] == "confirm") {



    // 入力内容整形
    foreach ($_POST as $k => $v) {
        if (!is_array($v)) {
            $v = stripslashes($v);
            $v = htmlspecialchars($v);
            $_POST[$k] = $v;
        }
    }

    // 入力内容チェック
    $chk_err = 0; // デフォルト値はエラー無し
    
    foreach ($_POST as $k => $v) {
        
        if (strpos($k, "__i") && (!$v) && !strpos($k, "__i_0")) { // name 値に"__i"があり、value が空の場合
            $chk_err = 1; // エラーを返す
            break;
        } elseif (strpos($k, "__i") && is_array($v)) { // チェックボックス（配列）の場合
            foreach ($_POST[$k] as $k2 => $v2) {
                if (!$v2) { // value が空の場合
                    $chk_err = 1; // エラーを返す
                } else { // 値が入っている場合
                    $chk_err = 0; // エラー無し
                    break;
                }
            }
        }
    }
    
    // メールアドレスチェック
    if (!$_POST["mail__i"]) {
        $chk_err = 1; // エラーを返す
    } elseif (!isValidInetAddress($_POST["mail__i"])) {
        $chk_err = 1; // エラーを返す
        $chk_err_mail = 1; // エラーを返す（メールチェック用）
    }
    
    // ひらがなチェック
    /*
    if ($_POST["sei2__i"]) {
        if (!mb_ereg("^[ぁ-ん]+$", $_POST["sei2__i"])) {
            $chk_err = 1; // エラーを返す
            $chk_err_sei2 = 1; // エラーを返す（かなチェック用）
        }
    }
    */



    // エラー分岐
    
    if ($chk_err == 1) {
    // 入力項目にエラーがある場合
        
        // 入力されていない項目にエラーを表示させる
        $err_str = '<br><span class="pf-text-error">▲入力してください。</span>'; // エラー文言
        $err_str2 = '<br><span class="pf-text-error">▲選択してください。</span>'; // エラー文言
        $err_str3 = '<br><span class="pf-text-error">▲電話番号が正しくありません。</span>'; // エラー文言
        $err_str4 = '<br><span class="pf-text-error">▲メールアドレスが正しくありません。</span>'; // エラー文言
        $err_str5 = '<br><span class="pf-text-error">▲ひらがなで入力してください。</span>'; // エラー文言
        foreach ($_POST as $k => $v) {
            if (!$v) {
                // input 系エラー
                $disp_error[$k] = $err_str;
            } elseif (is_array($v)) {
                // select,checkbox 系エラー
                foreach ($_POST[$k] as $k2 => $v2) {
                    if (!$v2) { // value が空の場合
                        $disp_error[$k] = $err_str2;
                    } else {
                        $disp_error[$k] = "";
                        break;
                    }
                }
            }
        }
        
        // 例外エラー
        if($chk_err_mail == 1){$disp_error["mail__i"] = $err_str4;}
        //if($chk_err_sei2 == 1){$disp_error["sei2__i"] = $err_str5;}
        
        // チェックされている項目にチェックをつける
        $chk_str = " checked=\"checked\""; // エラー文言
        foreach ($_POST as $k => $v) {
            if (is_array($v)) {
                foreach ($_POST[$k] as $k2 => $v2) {
                    if ($v2) {
                        $checked[$k][$k2] = $chk_str;
                    }
                }
            } else {
                $checked[$k] = $chk_str;
            }
        }
        
        // アクションキーは[enter]
        $act = "enter";
    
    
    
    } elseif ($chk_err == 0) {
    // 正常に入力されている場合
        
        // hidden 項目を書き出し
        foreach ($_POST as $k => $v) {
            if (is_array($v)) {
                foreach ($_POST[$k] as $k2 => $v2) {
                    if (!($v2 == "")) {
                        $hiddenitems .= "    <input type=\"hidden\" name=\"" . $k . "[" . $k2 . "]\" value=\"" . $v2 . "\" />\n";
                    }
                }
            } elseif(!($k == "act")) {
                $hiddenitems .= "    <input type=\"hidden\" name=\"" . $k . "\" value=\"" . $v . "\" />\n";
            }
        }
        
        // アクションキーは[confirm]
        $act = "confirm";
    }



}






/* ------------------------------
 * 確認画面のボタン押下時チェック
 * ------------------------------*/

if ($_POST["act"] == "complete") {



    // 入力内容整形
    foreach ($_POST as $k => $v) {
        if (!is_array($v)) {
            $v = stripslashes($v);
            $v = htmlspecialchars($v);
            $_POST[$k] = $v;
        }
    }

    // 入力内容チェック
    $chk_err = 0; // デフォルト値はエラー無し
    
    foreach ($_POST as $k => $v) {
        
        if (strpos($k, "__i") && (!$v) && !strpos($k, "__i_0")) { // name 値に"__i"があり、value が空の場合
            $chk_err = 1; // エラーを返す
            break;
        } elseif (strpos($k, "__i") && is_array($v)) { // チェックボックス（配列）の場合
            foreach ($_POST[$k] as $k2 => $v2) {
                if (!$v2) { // value が空の場合
                    $chk_err = 1; // エラーを返す
                } else { // 値が入っている場合
                    $chk_err = 0; // エラー無し
                    break;
                }
            }
        }
    }
    
    // メールアドレスチェック
    if (!$_POST["mail__i"]) {
        $chk_err = 1; // エラーを返す
    } elseif (!isValidInetAddress($_POST["mail__i"])) {
        $chk_err = 1; // エラーを返す
        $chk_err_mail = 1; // エラーを返す（メールチェック用）
    }
    
    // ひらがなチェック
    /*
    if ($_POST["sei2__i"]) {
        if (!mb_ereg("^[ぁ-ん]+$", $_POST["sei2__i"])) {
            $chk_err = 1; // エラーを返す
            $chk_err_sei2 = 1; // エラーを返す（かなチェック用）
        }
    }
    */



    // エラー分岐
    
    if ($chk_err == 1 || isset($_POST["back"])) {
    // 入力項目にエラーがある場合 もしくは 戻るボタンが押された時
        
        // 入力されていない項目にエラーを表示させる
        $err_str = '<br><span class="pf-text-error">▲入力してください。</span>'; // エラー文言
        $err_str2 = '<br><span class="pf-text-error">▲選択してください。</span>'; // エラー文言
        $err_str3 = '<br><span class="pf-text-error">▲電話番号が正しくありません。</span>'; // エラー文言
        $err_str4 = '<br><span class="pf-text-error">▲メールアドレスが正しくありません。</span>'; // エラー文言
        $err_str5 = '<br><span class="pf-text-error">▲ひらがなで入力してください。</span>'; // エラー文言
        foreach ($_POST as $k => $v) {
            if (!$v) {
                // input 系エラー
                $disp_error[$k] = $err_str;
            } elseif (is_array($v)) {
                // select,checkbox 系エラー
                foreach ($_POST[$k] as $k2 => $v2) {
                    if (!$v2) { // value が空の場合
                        $disp_error[$k] = $err_str2;
                    } else {
                        $disp_error[$k] = "";
                        break;
                    }
                }
            }
        }
        
        // 例外エラー
        if($chk_err_mail == 1){$disp_error["mail__i"] = $err_str4;}
        //if($chk_err_sei2 == 1){$disp_error["sei2__i"] = $err_str5;}
        
        // チェックされている項目にチェックをつける
        $chk_str = " checked=\"checked\""; // エラー文言
        foreach ($_POST as $k => $v) {
            if (is_array($v)) {
                foreach ($_POST[$k] as $k2 => $v2) {
                    if ($v2) {
                        $checked[$k][$k2] = $chk_str;
                    }
                }
            } else {
                $checked[$k] = $chk_str;
            }
        }
        
        // アクションキーは[enter]
        $act = "enter";
    
    
    
    } elseif ($chk_err == 0) {
    // 正常に入力されている場合
        
        // アクションキーは[complete]
        $act = "complete";
    }



}



// テンプレート画面表示
include_once "template/template.html";



/* ------------------------------
 * 画面遷移
 * ------------------------------*/

function drawScr($act, $disp_error, $checked, $hiddenitems, $_POST) {

    // 分岐
    switch ($act) {
        
        case "enter":
            scr_enter($disp_error, $checked);
            break;
        
        case "confirm":
            scr_confirm($disp_error, $checked, $hiddenitems);
            break;
        
        case "complete":
            scr_conplete($_POST);
            break;
        
        default:
            scr_enter();
    
    }

}



// 入力画面表示関数
function scr_enter($disp_error, $checked) {
    include_once "template/enter.html";
}


// 確認画面表示関数
function scr_confirm($disp_error, $checked, $hiddenitems) {
    include_once "template/confirm.html";
}


// 完了画面表示関数
function scr_conplete($_POST) {

    // checkbox 項目を書き出し
    foreach ($_POST as $k => $v) {
        if (is_array($v)) {
            foreach ($_POST[$k] as $k2 => $v2) {
                $checkboxitems[$k] .= "・" . $v2 . "\n";
            }
            $_POST[$k] = $checkboxitems[$k];
        }
    }
    
    
    // メール送信関数 ここから------------------------------
    function sendMail($_POST, $mailfrom, $mailTo, $mailSubject, $mailBody) {
        include_once "mail.inc";
        
        // メール送信関数
        if (mb_send_mail($mailTo, $mailSubject, $mailBody, $mailfrom)) { // 送信が成功したら
            include_once "template/thanks.html";
        } else { // 送信が失敗したら
            include_once "template/error.html";
        }
    }
    // メール送信関数 ここまで------------------------------
    
    
    // ユーザメール送信関数 ここから------------------------------
    function usrSendMail($_POST, $mailfrom, $mailTo, $mailSubject, $mailBody) {
        include_once "usermail.inc";
        
        // ユーザメール送信関数
        if (mb_send_mail($mailTo, $mailSubject, $mailBody, $mailfrom)) { // 送信が成功したら
            include_once "template/thanks.html";
        } else { // 送信が失敗したら
            include_once "template/error.html";
        }
    }
    // ユーザメール送信関数 ここまで------------------------------
    
    
    // CSV 生成関数 ここから------------------------------
    function genCSV($_POST) {
        // カンマが記入されていたらクォーテーションをつける
        foreach($_POST as $key => $val) {
            if (stristr($val, ',')){
                $val = '"' . $val . '"';
            } elseif (preg_match("/\n/", $val)) {
                $val = '"' . $val . '"';
            }
            $POSTarr[$key] = $val;
        }
        
        // 配列の"act","x","y"を削除
        unset($POSTarr[act]);
        unset($POSTarr[x]);
        unset($POSTarr[y]);
        unset($POSTarr[go]);
        
        // 投稿されたデータを結合
        $glue = ",";
        $POSTarr = implode($glue, $POSTarr);
        
        // 文字コードをSJISに変換
        $POSTarr = mb_convert_encoding($POSTarr, "SJIS", "UTF-8");
        
        $fileName = "data/file.csv";
        $fp = fopen($fileName, "a"); // ファイルオープン
        
        if (flock($fp, LOCK_EX)) { // 排他的ロックを行う
            fwrite($fp,
            mb_convert_encoding(date("Y年n月j日G時i分s秒"), "SJIS", "UTF-8") . ',' .
            $POSTarr
            . "\n"
            );
            flock($fp, LOCK_UN); // ロックを解放する
            print (''); // 完了メッセージ
        } else {
            print (''); // エラー発生時メッセージ
        }
        
        fclose($fp);// ファイルクローズ
    }
    // CSV 生成関数 ここまで------------------------------
    
    
    /* ------------------------------
     * メール送信関数実行
     * ------------------------------*/
    sendMail($_POST, $mailfrom, $mailTo, $mailSubject, $mailBody);
    usrSendMail($_POST, $mailfrom, $mailTo, $mailSubject, $mailBody);
    //genCSV($_POST);

}

