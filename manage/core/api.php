<?php
  header('Content-Type: application/json; charset=utf8');
  require_once('public.php');
  require_once('config.php');

  if (isset($_GET['exec']) && isset($_GET['daemon'])){

    $exec = strtolower($_GET['exec']);
    $name = $_GET['daemon'];
    $key  = $_GET['key'];

    $admin_active = getenv('NODE_ADMIN');
    $admin_pass   = getenv('ADMIN_PASS');

    if ($admin_active){
      $version     = @file_get_contents('core/update');
      $new_version = @file_get_contents('https://formatcom.github.io/nodeShared/update');

      echo "$version\n";
      echo "$new_version\n";

      if ($new_version > $version){
        $DAEMON['update'] = new Node('update', $admin_pass, getcwd(), 'sh core/update.sh core');
      }else if ($name === 'update'){
        die('You have the most recent version.');
      }
    }

    if(!isset($DAEMON[$name])){
      $data = Array('running' => false, 'state' => 0);
      die($_GET['callback']."(".json_encode($data).")");
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
