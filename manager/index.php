<?php
  header('Content-Type: application/json; charset=utf8');
  require_once('public.php');
  require_once('config.php');

  if (isset($_GET['exec']) && isset($_GET['daemon'])){

    $exec = strtolower($_GET['exec']);
    $name = $_GET['daemon'];
    $key  = $_GET['key'];

    if(!isset($DAEMON[$name])){
      $data = Array('running' => false, 'state': 0);
      die($_GET['callback']."([".json_encode($data)."])");
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
