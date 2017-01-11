Mini Instruccines
  
  1.- configurar el archivo config.php y public.php que se
  encuentran dentro de la carpeta manage.

  2.- subir la carpeta manage a tu hosting compartido
  en la carpeta publica de tu servidor comunmente
  tienen como nombre www/html_public.

  3.- si en las configuraciones tienes activo el modo admin
  este te permite acceder a una terminal desde el navegador
  desde la url www.tudominio.com/manage/shell

NOTAS:

  1.- no se recomienda dejar el modo admin activo, el mismo viene
  activado por defecto.

  2.- para evitar que el daemon muera utilizando nodeShared debes
  crear como pagina princial un ajax que ataque a tu daemon 
  utilizando la instruccion de exec para que nodeShared siempre
  verifique si este se encuentra activo y de caso contrario
  activarlo.

  Esa pagina de inicio una vez que haga el ajax se recomienda
  redireccionarlo a tu daemon [ al servidor de tu app ] por 
  ejemplo www.tudominio.com/app  <- y asi el usurio nunca
  tendra que ver un servidor caido.

  3.- estas mini instrucciones no son muy claras y se estan
  trabajando en ellas, junto a un video tutorial. de momento
  es lo maximo que puedo dejarles. espero que sea de utilidad
  y cualquier error reportarlo seria de mucha utilidad.

  vinicio.valbuena89 at gmail dot com


MANAGE METHODS GET/POST

  https://example.com/manage/deamon/exec/key
  https://example.com/manage/?daemon=app&exec=start&key=password

  ARGS:

  daemon === NAME OF THE DAEMON
  key    === API KEY
  exec   === [ start | status | stop ]

COMMAND LINE

  php manage/index.php daemon exec key

LIST STATES
  
  0 === ERROR     | NO ACTION
  1 === START     | RUN THE DAEMON
  2 === RUNNING   | NO ACTION
  3 === NORUNNING | NO ACTION
  4 === STOP      | STOP THE DAEMON

REQUIREMENTS VERSION PHP
  
  1.- hosting shared on linux
  2.- functions enabled: exec
  3.- apache mod_rewrite enabled
  4.- apache mod_proxy   enabled


REQUIREMENTS VERSION PYTHON (working)

  1.- hosting shared on linux
  2.- apache cgi_module  enabled
  3.- apache mod_rewrite enabled
  4.- apache mod_proxy   enabled



SYNTAX NEW NODE DAEMON => manage/config.php

  new Node('Name', password, 'project dir', 'shell script', modo, watch, report)

  - MODO

      0 === [START | STOP]
      1 ===      START
      2 ===      STOP

  - WATCH

      false => use in script
      true  => use in app/server

  - REPORT

      true/false (send mail)
