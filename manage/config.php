<?php
  require_once('nodeShared/index.php');

  ENV::set('NODE_HOME',   '/home/formatcom');

  // SET ADMIN MODE
  ENV::set('NODE_ADMIN', false);
  ENV::set('NODE_ADMIN_PASS', 'password');

  ENV::set('NODE_DEBUG', true);

  ENV::set('NODE_SHELL_SUPPORT', true);

  ENV::set('NODE_MAIL', 'formatcomvinicio@gmail.com');
  ENV::set('NODE_ACCESS', 'https://formatcom.alwaysdata.net');

  // SET ENV PATH
  ENV::setPath(Array(
    'node' => '/home/username/bin',
  ));

  /*
   * SYNTAX NEW NODE DAEMON
   *
   * new Node('Name', password, 'project dir', env,  'shell script', modo, watch, report)
   * env  = Array(
   *    'PORT' => 3000,
   *    )
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
    'google' => new Node('google', '123456', '/home/formatcom', Array(), 'ping -c 50 google.com', 0, false, false),
  );









 ?>
