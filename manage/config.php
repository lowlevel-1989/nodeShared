<?php
  require_once('nodeShared/index.php');

  ENV::set('NODE_HOME', '/home/formatcom'); # Asignar la ruta del home del usuario

  // SET ADMIN MODE
  ENV::set('NODE_ADMIN', true); # Modo admin
  ENV::set('NODE_ADMIN_USER', 'formatcom'); # usuario admin
  ENV::set('NODE_ADMIN_PASS', 'password'); # password

  ENV::set('NODE_DEBUG', true); # muestra mas informacion sobre las app corriendo

  ENV::set('NODE_SHELL_SUPPORT', true); # soporta acceso a la shell
  ENV::set('NODE_HIDDEN_SUPERVISOR', true); # muestra error 404 al acceder al supervisor
  ENV::set('NODE_API_REST_SUPPORT', false); # manage con soporte desde api rest
  ENV::set('NODE_API_METHOD_GET_SUPPORT', false); # activar soporte por metodo get

  ENV::set('NODE_MAIL', 'formatcomvinicio@gmail.com'); # correo del administrador
  ENV::set('NODE_ACCESS', 'https://formatcom.alwaysdata.net'); # sitio web desde donde se accede al manage



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
