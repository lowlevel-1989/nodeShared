MANAGE METHODS GET -> RETURN JSONP

  https://example.com/manage

  ARGS:

  daemon === NAME OF THE DAEMON
  exec   === [ start | status | stop ]
  key    === API KEY


LIST STATES
  
  0 === ERROR     | NO ACTION
  1 === START     | RUN THE DAEMON
  2 === RUNNING   | NO ACTION
  3 === NORUNNING | NO ACTION
  4 === STOP      | STOP THE DAEMON

REQUIREMENTS
  
  1.- hosting shared on linux
  2.- safe mode off
  3.- functions enabled: exec, passthru






