<?php
class Record {

  public $mode; // ゲームモード
  public $top1; // ビクトリー回数
  public $top5;
  public $top6;
  public $top10;
  public $top12;
  public $top25;
  public $kd; // キルデス比
  public $winRatio; // 勝率
  public $matches; // マッチ回数
  public $kills; // キル総数

  // 初期化
  function __construct($json, $mode) {
    $this->mode = $mode;
    $this->top1 = $json['top1']['displayValue'];
    $this->top5 = $json['top5']['displayValue'];
    $this->top6 = $json['top6']['displayValue'];
    $this->top10 = $json['top10']['displayValue'];
    $this->top12 = $json['top12']['displayValue'];
    $this->top25 = $json['top25']['displayValue'];
    $this->kd = $json['kd']['displayValue'];
    $this->winRatio = $json['winRatio']['displayValue'];
    $this->matches = $json['matches']['displayValue'];
    $this->kills = $json['kills']['displayValue'];
  }

  function getTexts() {
    $text = "\n". 
    '✔ ' . $this->mode . '------------' ."\n" .
    '👑 Victory   : ' . $this->top1 ."\n";
    if (!empty($this->top5 )) { $text = $text. '😘 Top5      : ' . $this->top5 ."\n"; }
    if (!empty($this->top6 )) { $text = $text. '😆 Top6      : ' . $this->top6 ."\n"; }
    if (!empty($this->top10)) { $text = $text. '😃 Top10     : ' . $this->top10 ."\n"; }
    if (!empty($this->top12)) { $text = $text. '😅 Top12     : ' . $this->top12 ."\n"; }
    if (!empty($this->top25)) { $text = $text. '😂 Top25     : ' . $this->top25 ."\n"; }
    $text = $text . '📈 WinRatio  : ' . $this->winRatio .'%'. "\n" .
    '🔥 Matches   : ' . $this->matches ."\n" .
    '🔫 Kills     : ' . $this->kills ."\n" .
    '💀 K/D       : ' . $this->kd ."\n";
    return $text;
  }
 }
 ?>