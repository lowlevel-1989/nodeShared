<?php

class Node{

  //List status.
  private static $ERROR     = 0;
  private static $START     = 1;
  private static $RUNNING   = 2;
  private static $NORUNNING = 3;
  private static $STOP      = 4;

  private $DAEMON, $NODE_ROOT, $NODE_APP, $NODE_ARGS;
  private $NODE_DIR, $NODE_PASS;

  public function Node($DAEMON, $NODE_ROOT, $NODE_APP, $NODE_ARGS) {
    $this->DAEMON       = strtolower($DAEMON);
    $this->NODE_ROOT    = $NODE_ROOT;
    $this->NODE_APP     = $NODE_APP;
    $this->NODE_ARGS    = $NODE_ARGS;
    $this->NODE_DIR     = getenv('HOME').'/daemon';
    $this->NODE_PASS    = getenv('NODE_PASS');
  }

  private function writeFile($FILE, $STRING) {
    $now    = date('d-m-Y H:i:s|');
    $buffer = @fopen("$this->NODE_DIR/$FILE", 'a+');
    @fwrite($buffer, "$this->DAEMON|$now$STRING\r");
    @fclose($buffer);
  }

  private function report($STATUS) {
    if ($STATUS === self::$START || $STATUS === self::$RUNNING) $data = array('running' => true, 'status' => $STATUS);
    else $data = array('running' => false, 'status' => $STATUS);
    return $_GET['callback']."([".json_encode($data)."])";
  }

  public function start($PASS) {

    if(!file_exists($this->NODE_DIR)) mkdir("$this->NODE_DIR/pid", 0755, true);

    if($PASS !== $this->NODE_PASS){
      $this->writeFile('error.log', 'ERROR PASSWORD.');
      return $this->report(self::$ERROR);
    }

  	$node_pid = @intval(file_get_contents("$this->NODE_DIR/pid/$this->DAEMON"));

    if(file_exists("/proc/$node_pid")) return $this->report(self::$RUNNING);
    elseif ($node_pid > 0) $this->writeFile('error.log', "DOWN APP SERVER IN PID: $node_pid.");

    chdir($this->NODE_ROOT);

  	$node_pid = processBackground($this->NODE_APP, $this->NODE_ARGS);
    @file_put_contents("$this->NODE_DIR/pid/$this->DAEMON", $node_pid, LOCK_EX);

    if($node_pid > 0){
      $this->writeFile("access.log", "APP START IN PID: $node_pid.");
      // writeHtaccess($URL); //var in ../public.php
      return $this->report(self::$START);
    }else{
      $this->writeFile("error.log", "ERROR APP START.");
      return $this->report(self::$ERROR);
    }
  }

  public function stop($PASS) {

    if($PASS !== $this->NODE_PASS){
      $this->writeFile("error.log", "ERROR PASSWORD.");
      return $this->report(self::$ERROR);
    }

    $node_pid = @intval(file_get_contents("$this->NODE_DIR/pid/$this->DAEMON"));

  	if($node_pid === 0) return $this->report(self::$NORUNNING);

    if(!file_exists("/proc/$node_pid")){
      $this->writeFile('error.log', "DOWN APP SERVER IN PID: $node_pid.");
      @file_put_contents("$this->NODE_DIR/pid/$this->DAEMON", '', LOCK_EX);
      return $this->report(self::$NORUNNING);
    }

  	$ret = -1;
  	passthru("kill $node_pid", $ret);

    if($ret === 0){
      $this->writeFile('access.log', "APP STOP IN PID: $node_pid.");
      @file_put_contents("$this->NODE_DIR/pid/$this->DAEMON", '', LOCK_EX);
      return $this->report(self::$STOP);
    }else{
      $this->writeFile('error.log', "ERROR STOP APP IN PID: $node_pid.");
      return $this->report(self::$ERROR);
    }
  }

  public function getStatus(){
    $node_pid = @intval(file_get_contents("$this->NODE_DIR/pid/$this->DAEMON"));
    if(file_exists("/proc/$node_pid")) return $this->report(self::$RUNNING);
    else return $this->report(self::$NORUNNING);
  }

}

?>
