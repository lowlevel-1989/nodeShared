<?php

define("UNDEFINE", 0);
define("ERROR", 1);
define("START", 2);
define("RUNNING", 3);
define("NORUNNING", 4);
define("STOP", 5);

class Node{

  private $NODE_DIR, $NODE_PORT, $NODE_PID_DIR, $NODE_APP, $ADMIN_PASS;

  public function Node($NODE_DIR, $NODE_PORT, $NODE_PID_DIR, $NODE_APP, $ADMIN_PASS) {
    $this->NODE_DIR     = $NODE_DIR; //Carpeta de Nodejs.
    $this->NODE_PORT    = $NODE_PORT; //Puerto del servidor Nodejs.
    $this->NODE_PID_DIR = $NODE_PID_DIR; //Carpeta donde se almacena direccion del proceso.
    $this->NODE_APP     = $NODE_APP; //Aplicacion Nodejs.
    $this->ADMIN_PASS   = $ADMIN_PASS; //Password para las peticiones.
  }

  private function report($STATUS) {
    if ($STATUS === START || $STATUS === RUNNING) $data = array("running" => true, "status" => $STATUS);
    else $data = array("running" => false, "status" => $STATUS);
    return $_GET['callback']."([".json_encode($data)."])";
  }

  public function start($PASS) {

    if($PASS !== $this->ADMIN_PASS) return $this->report(ERROR);

    if(!file_exists($this->NODE_DIR)) return $this->report(UNDEFINE);

  	$node_pid = @intval(file_get_contents("$this->NODE_PID_DIR/nodepid"));

  	if($node_pid > 0) return $this->report(RUNNING);

    if(!file_exists($this->NODE_APP)) return $this->report(ERROR);

  	$file = escapeshellarg($this->NODE_APP);

  	$node_pid = exec("PORT=$this->NODE_PORT $this->NODE_DIR/bin/node $file > /dev/null & echo $!");

    file_put_contents("$this->NODE_PID_DIR/nodepid", $node_pid, LOCK_EX);
  	sleep(1); //Espera que se levante Notejs.

    if($node_pid > 0) return $this->report(START);
    else return $this->report(ERROR);
  }

  public function stop($PASS) {

    if($PASS !== $this->ADMIN_PASS) return $this->report(ERROR);

    if(!file_exists($this->NODE_DIR)) return $this->report(UNDEFINE);

    $node_pid = @intval(file_get_contents("$this->NODE_PID_DIR/nodepid"));

  	if($node_pid === 0) return $this->report(NORUNNING);

  	$ret = -1;
  	passthru("kill $node_pid", $ret);


    if($ret === 0){
      file_put_contents("$this->NODE_PID_DIR/nodepid", '', LOCK_EX);
      return $this->report(STOP);
    }else return $this->report(ERROR);
  }

}

?>
