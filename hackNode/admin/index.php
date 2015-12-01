<?php
  require_once("../config.php");
  if(isset($_POST[pass])){
    $pass = $_POST[pass];
    if ($pass === ADMIN_PASS){
      $response = $DAEMONS["admin"]->start(ADMIN_PASS);
      //analiza la respuesta si esta corriendo redicciona a la add admin nodejs.
    }
  }
?>

<!-- Aqui dise;a el formulario principal -->
