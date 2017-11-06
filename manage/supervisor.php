<?php
  require_once('index.php');

  $DAEMON['beat']->supervisor();
  // Asignar todos los daemon que quieras supervisar
  // supervisor.php se debe atacar por ajax o por curl
  $DAEMON['app']->supervisor();
?>
