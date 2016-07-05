<?php
  header('Content-Type: application/json; charset=utf8');
  if (isset($argv[1]) and isset($argv[2])){
    chdir(getenv('NODE_PUBLIC').'/manage');
  }
  require_once('public.php');
  require_once('config.php');

  $_active = false;

  if (isset($_GET['exec']) and isset($_GET['daemon'])){
    $exec = strtolower($_GET['exec']);
    $name = $_GET['daemon'];
    $key  = $_GET['key'];
    $_active = true;
  }

  if (isset($argv[1]) and isset($argv[2]) and getenv('NODE_SHELL_SUPPORT')){
    $exec = strtolower($argv[2]);
    $name = $argv[1];
    $key  = $argv[3];
    $_active = true;
  }

  if ($_active){

    $admin_active = getenv('NODE_ADMIN');
    $admin_pass   = getenv('NODE_ADMIN_PASS');

    if ($admin_active){

      $version     = @file_get_contents('core/update');
      $new_version = @file_get_contents('https://formatcom.github.io/nodeShared/update');

      if ($new_version > $version){
        $DAEMON['update'] = new Node('update', $admin_pass, $PUBLIC, 'sh core/update.sh core', 1, 0);
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
