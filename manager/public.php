<?php
  require_once('core/access.php');

  $ROUTER = Array(
    'admin' => ['^manager/gui/admin/(.*?)$', 'http://127.0.0.1:49998/$1'],
    'root'  => ['^(.*?)$', 'http://127.0.0.1:49999/$1']
  );

  $EXCLUDE = Array('example') //EJEMPLO CON APACHE, carpeta example usara apache

  writeHtaccess($ROUTER, $EXCLUDE);
?>
