<?php
  function execute($PYTHON, $ARGS, $RETURN = false){
    $NULL = ' > /dev/null & echo $!';
    if ($RETURN === false){
      $ARGS = $ARGS.$NULL;
    }
    $result = @exec('python '.$PYTHON.' '.$ARGS);
    if ($RETURN){
      return $result;
    }
  }
?>
