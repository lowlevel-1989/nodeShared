<?php
  require_once("processBackground.php");

  class ENV{
    public function set($ENV, $ARGS){
      processBackground("export $ENV=$ARGS");
    }

    public function setPath($PATH){
      foreach ($PATH as $key => $value) {
        $this->set("PATH", '$PATH:'.$value);
      }
    }

    public function get(){
    }
  }

?>
