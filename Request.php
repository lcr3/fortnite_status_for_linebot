<?php
require_once 'Record.php';
require_once 'Stats.php';

class Request {
  //チャンネルアクセストークン
  public $channelAccessToken = 'HGc9/of1nSc5Zm68lUPaJCSCaY7PNK6c9NsWCh/xsi4T8VqHSdOGTJZDs892ybxVtt0CD1qiO1YFRxwSPGfP263F9B1I6NRmnljuhvRzmtxDqu9lhkBfLfzWmRVXnaYurn8uxxi+e2ZQxNrWWDh39wdB04t89/1O/w1cDnyilFU=';

  public $replyToken;
  public $messageText;

    function __construct($jsonObj) {
        $this->replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
        $this->messageText = $jsonObj->{"events"}[0]->{"message"}->{"text"};
        print($this->replyToken);
    }

    function setRequest() {
    $splits = explode(',', $this->messageText);
    if (count($splits) != 2) {
      // TODO: エラー処理
        var_dump("split error");
        $this->postMessage("情報がないよ");
      return;
    }
    $username = $splits[0];
    $platform = $splits[1];

    $stats = $this->getFortnitestats($username, $platform);
    var_dump($stats);
    if (empty($stats)) {
      // エラーだよ
      var_dump("stats null error");
      $stats = "エラーだよ";
      $this->postMessage("エラーだよ");
      return;
    }
    $this->postMessage($stats->getStatsText());
  }

    function getFortnitestats($epicName, $platform) {
    // fortniteTrackerへアクセス
    // エンコード
    $encodeName = urlencode($epicName);
    $cha = curl_init("https://api.fortnitetracker.com/v1/profile/". $platform . "/" . $encodeName);
    $fortnitetrackertoken = "3d80c353-1e3d-4352-8f2b-9be1ff27760e";
    curl_setopt($cha, CURLOPT_POST, true);
    curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($cha, CURLOPT_FAILONERROR, true);
    curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cha, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'TRN-Api-Key: ' . $fortnitetrackertoken
        ));
    $json = curl_exec($cha);
    curl_close($cha);

    if($json === false) {
        print('error');
        return null;
    }

    //受信したJSON文字列をデコードします
    $arr = json_decode($json,true);
    $stats = new Stats($arr);
    var_dump($json);
    return $stats;
  }

  //  メッセージを送る
  private function postMessage($text) {
    $response_format_text = [
      "type" => "text",
      "text" => $text
    ];
    $post_data = [
      "replyToken" => $this->replyToken,
      "messages" => [$response_format_text]
    ];
    var_dump($post_data);

    $ch = curl_init("https://api.line.me/v2/bot/message/reply");

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer hL1UuJ+2FzeVq6qwoSMA1HlaSQbX69A/Gm/aZht9+SM3rqj4ZeXqqANEL/+eZadbPuRFG0kJPVOCh8lgdAhOcQTMHnCa1/mlo7vaGY5xJg89eVk3pXf7KomMQQ4Vp++g6bc/Gmt4THmj7DOk5DK/2AdB04t89/1O/w1cDnyilFU='
    ));
    $result = curl_exec($ch);
    curl_close($ch);
  }
}
?>