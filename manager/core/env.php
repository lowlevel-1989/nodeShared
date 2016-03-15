<?php
  class ENV{

    private static function getPath(){
      return getenv('PATH');
    }

    public static function set($ENV, $ARGS){
      putenv("$ENV=$ARGS");
    }

    public static function setPath($PATH){
      foreach ($PATH as $key => $value) {
        self::set('PATH', $value.':'.self::getPath());
      }
    }
  }
?>
