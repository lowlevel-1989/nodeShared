<?php
  function processBackground($SCRIPT){
    return @exec("$SCRIPT > /dev/null & echo $!");
  }
?>
