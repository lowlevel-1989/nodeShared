<?php
  require_once('core/env.php');
  ENV::set('NODE_PUBLIC', dirname(__FILE__));
  if (isset($argv[1]) and isset($argv[2])){
    chdir(dirname(__FILE__));
  }
  require_once('core/api.php');
?>
