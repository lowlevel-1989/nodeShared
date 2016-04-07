<?php
  require_once('core/index.php');

  // SET ADMIN MODE
  ENV::set('NODE_ADMIN', true);
  ENV::set('ADMIN_PASS', 'password');


  // SET ENV PATH
  ENV::setPath(Array(
    'node' => '/home/davecas/bin',
  ));


  /*
   * SYNTAX NEW NODE DAEMON
   *
   * new Node('Name', password, 'project dir', 'shell script', modo)
   * MODO = [
   *   0 => (START | STOP) //DEFAULT
   *   1 =>     START
   *   2 =>     STOP
   * ]
   *
   */


  // SET NEW DAEMONS
  $DAEMON = Array(
    'test'  => new Node('test',  'password',     '/home/davecas',                  'ping -c 50 google.com', 1),
    'shell' => new Node('shell', '19987187',     '/home/davecas/apps/shell_exec',  'PORT=30000 node node_modules/.bin/coffee src/server'),
    'api'   => new Node('Api',   '20147555Dcas', '/home/davecas/apps/webzuliaapi', 'gunicorn -b 127.0.0.1:30001 webzuliaapi.wsgi:application', 1),
  );
 ?>
