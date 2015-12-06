<?php
  class ENV{
    public static function set($ENV, $ARGS){
      processBackground("export $ENV=$ARGS");
    }

    public static function setPath($PATH){
      foreach ($PATH as $key => $value) {
        self::set('PATH', '$PATH:'.$value);
      }
    }

    public static function get($ENV){
      return $_SERVER[$ENV];
    }
  }
?>
