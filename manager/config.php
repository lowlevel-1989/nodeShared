<?php
  require_once('core/index.php');
  // define('ADMIN_PASS', '12345Admin'); REESCRIBIR

  $PATH = Array(
    'node' => '/home/formatcom/node/bin'
  );

  // new Node('Name', 'bin', 'args')
  $DAEMON = Array(
    'admin' => new Node('Admin', 'node', 'panel/server/index.js'),
    'app'   => new Node('App', 'node', '/home/formatcom/index.js')
  );
 ?>
