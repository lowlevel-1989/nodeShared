<?php
  require_once('core/index.php');
  ENV::set('NODE_PASS', '12345Admin');

  ENV::setPath(Array(
    'node' => '/home/formatcom/node/bin'
  ));

  // new Node('Name', 'root', 'bin', 'args')
  $DAEMON = Array(
    'admin' => new Node('Admin', 'panel/server/', 'node', 'index.js'),
    'app'   => new Node('App', '/home/formatcom/', 'node', 'index.js')
  );
 ?>
