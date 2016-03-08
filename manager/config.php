<?php
  require_once('core/index.php');

  ENV::set('NODE_KEY', '12345Admin');

  ENV::setPath(Array(
    'node' => '/home/formatcom/node/bin'
  ));

  // new Node('Name', 'project dir', 'shell script')
  $DAEMON = Array(
    'admin' => new Node('Admin', 'gui/server/', 'PORT=49998 node .'),
    'app'   => new Node('App',   '/home/formatcom/project/', 'node server.js')
  );
 ?>
