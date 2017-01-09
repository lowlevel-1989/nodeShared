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
