<?php
  function processBackground($BIN, $ARGS=''){
    return exec("$BIN $ARGS > /dev/null & echo $!");
  }
?>
