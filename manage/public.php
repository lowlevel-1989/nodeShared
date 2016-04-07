<?php
  require_once('core/access.php');

  $HTACCESS = Array(
    'example' => '# ESTO ES UN COMENTARIO EN HTACCESS',
  );

  // EJEMPLO USANDO SHELL_EXEC -> https://github.com/formatcom/shell_exec
  $ROUTER = Array(
    'shell'  => ['^shell/(.*?)$', 'http://127.0.0.1:30000/$1'],
    'socket' => ['^socket.io/(.*?)$', 'http://127.0.0.1:30000/socket.io/$1'],
  );

  $REDIRECT301 = Array(
    'google' => ['^google/(.*?)$', 'https://google.com?q=$1'],
  );

  $EXCLUDE = Array('example',); //EJEMPLO CON APACHE, carpeta example usara apache

  writeHtaccess($HTACCESS, $ROUTER, $REDIRECT301, $EXCLUDE);
?>