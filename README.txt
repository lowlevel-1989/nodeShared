MANAGE METHODS GET -> RETURN JSONP

  https://example.com/manage/deamon/exec/key

  ARGS:

  daemon === NAME OF THE DAEMON
  key    === API KEY
  exec   === [ start | status | stop ]

COMMAND LINE

  NODE_PUBLIC=/home/username/www php manage/index.php daemon exec key

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


REQUIREMENTS VERSION PYTHON (working)

  1.- hosting shared on linux
  2.- apache cgi_module  enabled
  3.- apache mod_rewrite enabled


