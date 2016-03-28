<?php

class Node{

  //List status.
  private static $ERROR     = 0;
  private static $START     = 1;
  private static $RUNNING   = 2;
  private static $NORUNNING = 3;
  private static $STOP      = 4;

  private $DAEMON, $NODE_ROOT, $NODE_SCRIPT;
  private $NODE_DIR, $NODE_KEY, $NODE_ACTIVE;

  public function Node($DAEMON, $NODE_ROOT, $NODE_SCRIPT, $NODE_ACTIVE = true) {
    $this->DAEMON      = strtolower($DAEMON);
    $this->NODE_ROOT   = $NODE_ROOT;
    $this->NODE_SCRIPT = $NODE_SCRIPT;
    $this->NODE_ACTIVE = $NODE_ACTIVE;
    $this->NODE_DIR    = explode('/', $_SERVER['DOCUMENT_ROOT']);
    $this->NODE_DIR    = '/'.$this->NODE_DIR[1].'/'.$this->NODE_DIR[2].'/daemon';
    $this->NODE_KEY    = getenv('NODE_KEY');
  }

  private function writeFile($FILE, $STRING) {
    $now    = date('d-m-Y H:i:s|');
    $buffer = @fopen("$this->NODE_DIR/$FILE", 'a+');
    @fwrite($buffer, "$this->DAEMON|$now$STRING\r\n");
    @fclose($buffer);
  }

  private function report($STATUS) {
    if ($STATUS === self::$START || $STATUS === self::$RUNNING){
      $data = array('running' => true,  'status' => $STATUS);
    }else{
      $data = array('running' => false, 'status' => $STATUS);
    }  
    return $_GET['callback']."(".json_encode($data).")";
  }

  public function start($KEY) {

    if(!file_exists($this->NODE_DIR)){
      mkdir("$this->NODE_DIR/pid", 0755, true);
    }

    if($KEY !== $this->NODE_KEY){
      $this->writeFile('error.log', 'ERROR KEY.');
      return $this->report(self::$ERROR);
    }

    if(!$this->NODE_ACTIVE){
      $this->writeFile('error.log', 'DAEMON NO ACTIVE.');
      return $this->return(self::$ERROR);
    }

    $node_pid = @intval(file_get_contents("$this->NODE_DIR/pid/$this->DAEMON"));

    if(file_exists("/proc/$node_pid")){
      return $this->report(self::$RUNNING);
    }elseif ($node_pid > 0){
      $this->writeFile('error.log', "DOWN APP SERVER IN PID: $node_pid.");
    }

    if(!file_exists($this->NODE_ROOT)){
      $this->writeFile('error.log', 'ERROR NODE ROOT NO EXISTS.');
      return $this->report(self::$ERROR);
    }

    chdir($this->NODE_ROOT);

    $node_pid = processBackground($this->NODE_SCRIPT);
    @file_put_contents("$this->NODE_DIR/pid/$this->DAEMON", $node_pid, LOCK_EX);

    if($node_pid > 0){
      $this->writeFile("access.log", "APP START IN PID: $node_pid.");
      return $this->report(self::$START);
    }else{
      $this->writeFile("error.log", "ERROR APP START.");
      return $this->report(self::$ERROR);
    }
  }

  public function stop($KEY) {

    if($KEY !== $this->NODE_KEY){
      $this->writeFile("error.log", "ERROR KEY.");
      return $this->report(self::$ERROR);
    }

    $node_pid = @intval(file_get_contents("$this->NODE_DIR/pid/$this->DAEMON"));

    if($node_pid === 0){
      return $this->report(self::$NORUNNING);
    }

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
    if(file_exists("/proc/$node_pid")){
      return $this->report(self::$RUNNING);
    }else{
      return $this->report(self::$NORUNNING);
    }
  }

}

?>
