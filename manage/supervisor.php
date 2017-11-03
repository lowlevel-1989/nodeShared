<?php
  require_once('index.php');
  require_once('config.php');

  $DAEMON['beat']->supervisor();
  // Asignar todos los daemon que quieras supervisar
  // supervisor.php se debe atacar por ajax o por curl
  $DAEMON['app']->supervisor();
?>
