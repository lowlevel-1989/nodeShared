<?php
  require_once('nodeShared/index.php');

  ENV::set('NODE_HOME', '/home/formatcom');

  // SET ADMIN MODE
  ENV::set('NODE_ADMIN', true);
  ENV::set('NODE_ADMIN_USER', 'formatcom');
  ENV::set('NODE_ADMIN_PASS', 'password');

  ENV::set('NODE_DEBUG', true);

  ENV::set('NODE_SHELL_SUPPORT', true);
  ENV::set('NODE_API_REST_SUPPORT', false);
  ENV::set('NODE_API_METHOD_GET_SUPPORT', false);

  ENV::set('NODE_MAIL', 'formatcomvinicio@gmail.com');
  ENV::set('NODE_ACCESS', 'https://formatcom.alwaysdata.net');



  // SET ENV PATH
  ENV::setPath(Array(
    // https://nodejs.org/dist/v6.9.4/node-v6.9.4-linux-x64.tar.xz
    'node' => '/home/formatcom/node-v6.9.4-linux-x64/bin'
  ));

  /*
   * SYNTAX NEW NODE DAEMON
   *
   * new Node('Name', password, 'project dir', 'shell script', modo, watch, report)
   * MODO = [
   *   0 => (START | STOP)
   *   1 =>     START
   *   2 =>     STOP
   * ],
   * watch = [
   *  false => use in script
   *  true  => use in app/server
   * ],
   * report = true/false (send mail)
   *
   */


  // SET NEW DAEMONS
  $DAEMON = Array(
    'app' => new Node('app', 'password', '/home/formatcom/app', 'PORT=8000 node index.js', 0, true, false)
  );

 ?>
