<?php
  require_once('core/index.php');

  // SET ADMIN MODE
  ENV::set('NODE_ADMIN', false);
  ENV::set('ADMIN_PASS', 'password');


  // SET ENV PATH
  ENV::setPath(Array(
    'node' => '/home/username/bin',
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
    'test'  => new Node('test',  'password', '/home/username', 'ping -c 50 google.com', 1),
  );
 ?>
