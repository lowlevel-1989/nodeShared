<?php
  require_once('nodeShared/env.php');

  //se asigna una variable de entorno
  //con la ruta de nodeShared
  ENV::set('NODE_PUBLIC', dirname(__FILE__));

  //verificamos si esta ejecutado desde la terminal
  if (php_sapi_name() === 'cli'){

    //nos movemos a la carpeta del proyecto
    chdir(dirname(__FILE__));
  }
  require_once('nodeShared/api.php');
?>
