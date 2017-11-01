<?php
  require_once('nodeShared/env.php');

  //se asigna una variable de entorno
  //con la ruta de nodeShared
  ENV::set('NODE_PUBLIC', dirname(__FILE__));

  //verificamos args enviados desde la terminal
  if (isset($argv[1]) and isset($argv[2])){

    //nos movemos a la carpeta del proyecto
    chdir(dirname(__FILE__));
  }
  require_once('nodeShared/api.php');
?>
