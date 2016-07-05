<?php
  class ENV{

    private static function getPath(){
      return getenv('PATH');
    }

    public static function set($ENV, $ARGS){
      putenv($ENV.'='.$ARGS);
    }

    public static function setPath($PATH){
      $temp = self::getPath();
      foreach ($PATH as $key => $value) {
        $temp .= ':'.$value;  
      }
      self::set('PATH', $temp);
    }
  }
?>
