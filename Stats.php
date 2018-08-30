<?php
class Stats {

  public $name;
  public $solo;
  public $duo;
  public $squad;

  function __construct($json) {
    $this->name = $json['epicUserHandle'];
    $this->solo = new Record($json['stats']['curr_p2'], 'Solo');
    $this->duo = new Record($json['stats']['curr_p10'], 'Duo');
    $this->squad = new Record($json['stats']['curr_p9'], 'Squad');
  }

  function getStatsText() {
    $text = '✞' . $this->name . '✞' .
    $this->solo->getTexts() ."\n" .
    $this->duo->getTexts() ."\n" .
    $this->squad->getTexts() ."\n";
    return $text;
  }
}
?>