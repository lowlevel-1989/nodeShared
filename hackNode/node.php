<?php

class Node{

  //List status.
  private static $UNDEFINE  = 0;
  private static $ERROR     = 1;
  private static $START     = 2;
  private static $RUNNING   = 3;
  private static $NORUNNING = 4;
  private static $STOP      = 5;

  private $DAEMON, $NODE_DIR, $NODE_APP, $ADMIN_PASS;

  public function Node($DAEMON, $NODE_DIR, $NODE_APP, $ADMIN_PASS) {
    $this->DAEMON       = strtolower($DAEMON); //Nombre del daemon.
    $this->NODE_DIR     = $NODE_DIR; //Carpeta de Nodejs.
    $this->NODE_APP     = $NODE_APP; //Aplicacion Nodejs.
    $this->ADMIN_PASS   = $ADMIN_PASS; //Password para las peticiones.
  }

  private function writeFile($FILE, $STRING) {
    $now    = date("d-m-Y H:i:s -> ");
    $buffer = @fopen("$this->NODE_DIR/supervisor/$FILE", "a+");
    @fwrite($buffer, $now.$this->DAEMON.": ".$STRING."\r");
    @fclose($buffer);
  }

  private function report($STATUS) {
    if ($STATUS === self::$START || $STATUS === self::$RUNNING) $data = array("running" => true, "status" => $STATUS);
    else $data = array("running" => false, "status" => $STATUS);
    return $_GET['callback']."([".json_encode($data)."])";
  }

  public function start($PASS) {

    if(!file_exists($this->NODE_DIR)) return $this->report(self::$UNDEFINE);

    if(!file_exists("$this->NODE_DIR/supervisor")) mkdir("$this->NODE_DIR/supervisor/pid", 0755, true);

    if($PASS !== $this->ADMIN_PASS){
      $this->writeFile("error.log", "ERROR PASSWORD.");
      return $this->report(self::$ERROR);
    }

  	$node_pid = @intval(file_get_contents("$this->NODE_DIR/supervisor/pid/$this->DAEMON"));

    if(file_exists("/proc/$node_pid")) return $this->report(self::$RUNNING);

    if(!file_exists($this->NODE_APP)){
      $this->writeFile("error.log", "APP UNDEFINE.");
      return $this->report(self::$ERROR);
    }

  	$file = escapeshellarg($this->NODE_APP);

  	$node_pid = exec("$this->NODE_DIR/bin/node $file > /dev/null & echo $!");

    @file_put_contents("$this->NODE_DIR/supervisor/pid/$this->DAEMON", $node_pid, LOCK_EX);
  	sleep(1); //Espera que se levante Notejs.

    if($node_pid > 0){
      $this->writeFile("access.log", "APP START IN PID: $node_pid.");
      return $this->report(self::$START);
    }else{
      $this->writeFile("error.log", "ERROR APP START.");
      return $this->report(self::$ERROR);
    }
  }

  public function stop($PASS) {

    if(!file_exists($this->NODE_DIR)) return $this->report(self::$UNDEFINE);

    if($PASS !== $this->ADMIN_PASS){
      $this->writeFile("error.log", "ERROR PASSWORD.");
      return $this->report(self::$ERROR);
    }

    $node_pid = @intval(file_get_contents("$this->NODE_DIR/supervisor/pid/$this->DAEMON"));

  	if($node_pid === 0) return $this->report(self::$NORUNNING);

    if(!file_exists("/proc/$node_pid")){
      $this->writeFile("error.log", "DOWN APP SERVER IN PID: $node_pid.");
      @file_put_contents("$this->NODE_DIR/supervisor/pid/$this->DAEMON", '', LOCK_EX);
      return $this->report(self::$NORUNNING);
    }

  	$ret = -1;
  	passthru("kill $node_pid", $ret);

    if($ret === 0){
      $this->writeFile("access.log", "APP STOP IN PID: $node_pid.");
      @file_put_contents("$this->NODE_DIR/supervisor/pid/$this->DAEMON", '', LOCK_EX);
      return $this->report(self::$STOP);
    }else{
      $this->writeFile("error.log", "ERROR STOP APP IN PID: $node_pid.");
      return $this->report(self::$ERROR);
    }
  }

  public function getStatus($PASS){
    if($PASS !== $this->ADMIN_PASS){
      $this->writeFile("error.log", "ERROR PASSWORD.");
      return $this->report(self::$ERROR);
    }
    $node_pid = @intval(file_get_contents("$this->NODE_DIR/supervisor/pid/$this->DAEMON"));
    if(file_exists("/proc/$node_pid")) return $this->report(self::$RUNNING);
    else return $this->report(self::$NORUNNING);
  }

}

?>
