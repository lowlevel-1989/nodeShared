<?php
  require_once("../config.php");
  if(isset($_POST[pass])){
    $pass = $_POST[pass];
    if ($pass === getenv('NODE_PASS')){
      // $response = $DAEMONS["admin"]->start(ADMIN_PASS); cambiar por ajax
      //analiza la respuesta si esta corriendo redicciona a la app admin nodejs.
    }
  }
  echo getenv('NODE_PASS');
?>

<!-- Aqui dise;a el formulario principal -->
