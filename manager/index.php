<?php
  header('Content-Type: application/json; charset=utf8');
  require_once('public.php');
  require_once('config.php');

  if (isset($_REQUEST['exec']) && isset($_REQUEST['daemon'])){

    $exec = strtolower($_REQUEST['exec']);
    $name = $_REQUEST['daemon'];
    $key  = $_REQUEST['key'];

    if(!isset($DAEMON[$name])){
      die($_GET['callback']."([".json_encode({})."])");
    }

    switch ($exec) {
      case 'start':
        echo $DAEMON[$name]->start($key);
        break;
      case 'status':
        echo $DAEMON[$name]->getStatus();
        break;
      case 'stop':
        echo $DAEMON[$name]->stop($key);
        break;
    }
  }
?>
