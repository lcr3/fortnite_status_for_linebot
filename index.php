<?php
require_once 'Request.php';

//ユーザーからのメッセージ取得
$inputData = file_get_contents('php://input');
//受信したJSON文字列をデコードします
$jsonObj = json_decode($inputData);

//Webhook Eventのタイプを取得
$eventType = $jsonObj->{"events"}[0]->{"type"};
//テキスト、画像、スタンプなどの場合「message」になります

if ($eventType == 'message') {
  //ここで、受信したメッセージがテキストか画像かなどを判別できます
  $messageType = $jsonObj->{"events"}[0]->{"message"}->{"type"};
  //メッセージタイプがtextの場合の処理
  if ($messageType == 'text') {
    $request = new Request($jsonObj);
    $request->setRequest();
  } else {
    //上記以外のメッセージタイプ
    exit();
  }
}
?>