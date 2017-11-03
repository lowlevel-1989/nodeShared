<?php
  require_once('public.php');
  require_once('config.php');

  header("Access-Control-Allow-Origin: ".getenv('NODE_ACCESS'));
  header('Content-Type: application/json; charset=utf8');

  // flag se activa si los args son validos
  $_active = false;

  // Se verifica si tiene soporte para api rest
  if (getenv('NODE_API_REST_SUPPORT')) {
    if (isset($_POST['exec']) and isset($_POST['daemon'])){
      $exec = strtolower($_POST['exec']);
      $name = $_POST['daemon'];
      $key  = $_POST['key'];
      $_active = true;
    }
    if (isset($_GET['exec']) and isset($_GET['daemon']) and getenv('NODE_API_METHOD_GET_SUPPORT')){
      $exec = strtolower($_GET['exec']);
      $name = $_GET['daemon'];
      $key  = $_GET['key'];
      $_active = true;
    }
  }

  // verifica si el request viene desde la shell
  if (php_sapi_name() === 'cli' && isset($argv[1]) and isset($argv[2]) and getenv('NODE_SHELL_SUPPORT')){

    if ($argv[1] == '-i'){
      if ($argv[2] == 'version') {
        $_version = @trim(file_get_contents(dirname(__FILE__).'/version'));
        $_version = 'nodeShared version: '.$_version."\r\n";
        die($_version);
      }

      if ($argv[2] == 'list') {
	echo "daemon list\r\n";
        foreach ($DAEMON as $name => $node){
      	  echo "- ".$name."\r\n";
        }
        die();
      }

      if ($argv[2] == 'help') {
        $_version = @trim(file_get_contents(dirname(__FILE__).'/version'));
        $_version = 'version: '.$_version."\r\n\r\n";
        $help = "nodeShared creado por Vinicio Valbuena\r\n";
        $help .= "formatcomvinicio at gmail dot com\r\n";
        $help .= $version;
        $help .= "\r\n- ver ayuda\r\n";
        $help .= "manage -i help\r\n\r\n";
        $help .= "- ver version\r\n";
        $help .= "manage -i version\r\n\r\n";
        $help .= "- listar apps\r\n";
        $help .= "manage -i list\r\n\r\n";
        $help .= "- ver estado\r\n";
        $help .= "manage {app} status\r\n\r\n";
        $help .= "- ejecutar una app\r\n";
        $help .= "manage {app} start\r\n\r\n";
        $help .= "- detener una app\r\n";
        $help .= "manage {app} stop\r\n\r\n\r\n";
        $help .= "DAEMON ESPECIALES\r\n\r\n";
        $help .= "- actualizar nodeShared\r\n";
        $help .= "manage update start\r\n\r\n";
        $help .= "- activar beat\r\n";
        $help .= "manage beat start\r\n\r\n";
        $help .= "- ver estado del beat\r\n";
        $help .= "manage beat status\r\n\r\n";
        $help .= "- detener el beat\r\n";
        $help .= "manage beat stop\r\n";
	die($help);
      }

    }


    $exec = strtolower($argv[2]);
    $name = $argv[1];
    $key  = getenv('NODE_ADMIN_PASS');
    $_active = true;
  }
  $DAEMON['beat'] = new Node('beat', getenv('NODE_ADMIN_PASS'), '.', 'python nodeShared/beat.py', 0, true, false);

  // verifica si todos los
  // args fueron validos
  if ($_active){

    $admin_active = getenv('NODE_ADMIN');
    $admin_pass   = getenv('NODE_ADMIN_PASS');

    // verifica si esta activo
    // el modo admin
    if ($admin_active){

      // lee la version local de nodeShared
      $version     = @file_get_contents('nodeShared/update');
      // lee la ultima version de nodeShared
      // en el servidor
      $new_version = @file_get_contents('https://formatcom.github.io/nodeShared/update');

      // verifica si tenemos la
      // ultima version instalada
      if ($new_version > $version){

	// crea el daemon update
	// es el encargado de actualizar
	// nodeShared
        $DAEMON['update'] = new Node('update', $admin_pass, '.', 'dos2unix nodeShared/update.sh && sh nodeShared/update.sh core', 1, false, false);
      }else if ($name === 'update'){
        die('You have the most recent version.');
      }
    }

    // se verifica si el daemon no existe
    if(!isset($DAEMON[$name])){
      die();
    }

    // se ejecuta la accion selecciona
    // por el usuario
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
