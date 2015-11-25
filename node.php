<?php

class Node{

  define("UNDEFINE", -1);
  define("ERROR", 0);
  define("START", 1);
  define("RUNNING", 2);
  define("NORUNNING", 3);
  define("STOP", 4);

  private $NODE_DIR, $NODE_PORT, $NODE_PID_DIR, $ADMIN_PASS;

  public function Node($NODE_DIR, $NODE_PORT, $NODE_PID_DIR, $ADMIN_PASS) {
    error_reporting(E_ALL); //Define tipos de errores a ejecutar.
    set_time_limit(120); //Tiempo maximo de ejecucion.

    $this->NODE_DIR     = $NODE_DIR; //Carpeta de Nodejs.
    $this->NODE_PORT    = $NODE_PORT; //Puerto del servidor Nodejs.
    $this->NODE_PID_DIR = $NODE_PID_DIR; //Carpeta donde se almacena direccion del proceso.
    $this->ADMIN_PASS   = $ADMIN_PASS; //Password para las peticiones.
  }

  private function report($STATUS) {
    switch ($STATUS) {
      case UNDEFINE:
        return "Node.js is not yet installed.";
      case ERROR:
        return "ERROR.";
      case START:
        return "Node.js is running.";
      case RUNNING:
        return "Node.js is already running.";
      case NORUNNING:
        return "Node.js is not yet running.";
      case STOP:
        return "Stopping Node.js.";
    }
  }

  public function start($FILE, $PASS) {

    if($PASS !== $this->ADMIN_PASS) return $this->report(ERROR);

    if(!file_exists($this->NODE_DIR)) return $this->report(UNDEFINE);

  	$node_pid = intval(file_get_contents("$this->NODE_PID_DIR/nodepid"));

  	if($node_pid > 0) return $this->report(RUNNING);

  	$file = escapeshellarg($FILE);

  	$node_pid = exec("PORT=$this->NODE_PORT $this->NODE_DIR /bin/node $file >$this->NODE_PID_DIR/nodepid 2>&1 & echo $!");

    file_put_contents("$this->NODE_PID_DIR/nodepid", $node_pid, LOCK_EX);
  	sleep(1); //Espera que se levante Notejs.

    if($node_pid > 0) return $this->report(START);
    else return $this->report(ERROR);
  }

  public function stop($PASS) {

    if($PASS !== $this->ADMIN_PASS) return $this->report(ERROR);

    if(!file_exists($this->NODE_DIR)) return $this->report(UNDEFINE);

    $node_pid = intval(file_get_contents("$this->NODE_PID_DIR/nodepid"));

  	if($node_pid === 0) return $this->report(NORUNNING);

  	$ret = -1;
  	passthru("kill $node_pid", $ret);
    file_put_contents("$this->NODE_PID_DIR/nodepid", '', LOCK_EX);

    if($ret === 0) return $this->report(STOP);
    else return $this->report(ERROR);
  }

}

?>
