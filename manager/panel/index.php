<?php
  require_once("../config.php");
  if(isset($_POST[pass])){
    $pass = $_POST[pass];
    if ($pass === ENV::get('NODE_PASS')){
      // $response = $DAEMONS["admin"]->start(ADMIN_PASS); cambiar por ajax
      //analiza la respuesta si esta corriendo redicciona a la app admin nodejs.
    }
  }
?>

<!-- Aqui dise;a el formulario principal -->
