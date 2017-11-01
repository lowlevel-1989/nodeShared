<?php

  function execute($SCRIPT, $DAEMON = false, $PATH_PID = false, $PATH_LOG = false){

    if ($DAEMON === false){
      return @exec($SCRIPT);
    }else{
      $STDOUT = $PATH_LOG.'/STDOUT.log';
      $STDERR = $PATH_LOG.'/STDERR.log';
      $PID    = @exec($SCRIPT.' > '.$STDOUT.' 2> '.$STDERR.' & echo $!');
      @file_put_contents($PATH_PID.'/'.$DAEMON, $PID, LOCK_EX);
      return $PID;
    }
  }

?>
