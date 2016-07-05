<?php

class Node{

  //List status.
  private static $ERROR     = 0;
  private static $START     = 1;
  private static $RUNNING   = 2;
  private static $NORUNNING = 3;
  private static $STOP      = 4;

  private $DAEMON,       $NODE_ROOT,    $NODE_SCRIPT;
  private $NODE_DIR,     $NODE_KEY,     $NODE_TYPE;
  private $NODE_ADMIN,   $ADMIN_PASS,   $NODE_WATCH;
  private $NODE_DIR_LOG, $NODE_DIR_PID, $PATH_BIN;
  private $NODE_REPORT,  $NODE_DEBUG,   $NODE_ROOT_DIR;

  public function Node($DAEMON, $NODE_KEY, $NODE_ROOT, $NODE_SCRIPT, $NODE_TYPE, $NODE_WATCH, $NODE_REPORT) {
    $this->DAEMON        = strtolower($DAEMON);
    $this->NODE_ROOT     = $NODE_ROOT;
    $this->NODE_SCRIPT   = $NODE_SCRIPT;
    $this->NODE_TYPE     = $NODE_TYPE;
    $this->NODE_ROOT_DIR = getenv('NODE_PUBLIC').'/manage';
    $this->PATH_BIN      = $this->NODE_ROOT_DIR.'/core';
    $this->NODE_DIR      = getenv('NODE_HOME').'/daemon';
    $this->NODE_DIR_PID  = $this->NODE_DIR.'/pid';
    $this->NODE_DIR_LOG  = $this->NODE_DIR.'/'.$this->DAEMON;
    $this->NODE_ADMIN    = getenv('NODE_ADMIN');
    $this->NODE_KEY      = $NODE_KEY;
    $this->ADMIN_PASS    = getenv('NODE_ADMIN_PASS');
    $this->NODE_WATCH    = $NODE_WATCH;
    $this->NODE_REPORT   = $NODE_REPORT;
    $this->NODE_DEBUG    = getenv('NODE_DEBUG');
    $this->MAIL          = getenv('NODE_MAIL');
  }

  private function writeFile($FILE, $STRING) {
    $now    = date('d-m-Y H:i:s|');
    $buffer = @fopen($this->NODE_DIR_LOG.'/'.$FILE, 'a+');
    @fwrite($buffer, $now.$STRING."\r\n");
    @fclose($buffer);
  }

  private function report($STATUS, $PID=null) {
    if ($STATUS === self::$START || $STATUS === self::$RUNNING){
      $data = array('running' => true,  'status' => $STATUS);
    }else{
      $data = array('running' => false, 'status' => $STATUS);
    }  
    if ($this->NODE_DEBUG){
      $data['pid']     = $PID;
      $data['version'] = '0.2.4';
      $data['type']    = $this->NODE_TYPE;
      $data['watch']   = $this->NODE_WATCH;
    }
    return $_GET['callback'].'('.json_encode($data).')';
  }

  public function start($KEY) {

    if(!file_exists($this->NODE_DIR)){
      mkdir($this->NODE_DIR_PID, 0755, true);
    }

    if(!file_exists($this->NODE_DIR_LOG)){
      mkdir($this->NODE_DIR_LOG, 0755, true);
    }

    if($KEY !== $this->NODE_KEY){
      if (($this->NODE_ADMIN && $KEY !== $this->ADMIN_PASS) || !$this->NODE_ADMIN) {
        $this->writeFile('error.log', 'ERROR KEY.');

        if ($this->NODE_REPORT){
          mail($this->MAIL, 'NODESHARED->ERROR: '.$this->DAEMON, 'ERROR KEY.');
        }

        return $this->report(self::$ERROR);
      }
    }
    
    if(!$this->NODE_ADMIN && $this->NODE_TYPE === 2){
      $this->writeFile('error.log', 'DAEMON NO ACTIVE. TYPE: '.$this->NODE_TYPE.'.');
      return $this->return(self::$ERROR);
    }

    $node_pid = @intval(file_get_contents($this->NODE_DIR_PID.'/'.$this->DAEMON));

    if ( (execute($this->PATH_BIN.'/pid.py', $node_pid, true) === 'True') and $node_pid !== 0){
      return $this->report(self::$RUNNING, $node_pid);
    }elseif ($node_pid > 0){
      if ($this->NODE_WATCH === 1){
        $this->writeFile('error.log', 'DOWN APP SERVER IN PID: '.$node_pid.'.');
        if ($this->NODE_REPORT){
          mail($this->MAIL, 'NODESHARED->ERROR: '.$this->DAEMON, 'DOWN APP SERVER IN PID: '.$node_pid.'.');
        }
      }else{
        $this->writeFile('access.log', 'APP STOP IN PID: '.$node_pid.'.');
        if ($this->NODE_REPORT){
          mail($this->MAIL, 'NODESHARED->STOP: '.$this->DAEMON, 'APP STOP IN PID: '.$node_pid.'.');
        }
      }
    }

    if(!file_exists($this->NODE_ROOT)){
      $this->writeFile('error.log', 'ERROR NODE ROOT NO EXISTS.');
      return $this->report(self::$ERROR);
    }

    chdir($this->NODE_ROOT);

    execute($this->PATH_BIN.'/exec.py', $this->NODE_DIR_PID.' '.$this->NODE_DIR_LOG.' '.$this->DAEMON.' '.$this->NODE_SCRIPT);
    sleep(1);

    $node_pid = @intval(file_get_contents($this->NODE_DIR_PID.'/'.$this->DAEMON));

    if($node_pid > 0){
      $this->writeFile('access.log', 'APP START IN PID: '.$node_pid.'.');
      if ($this->NODE_REPORT){
        mail($this->MAIL, 'NODESHARED->START: '.$this->DAEMON, 'APP START IN PID: '.$node_pid.'.');
      }
      return $this->report(self::$START, $node_pid);
    }else{
      $this->writeFile('error.log', 'ERROR APP START.');
      return $this->report(self::$ERROR);
    }

  }

  public function stop($KEY) {

    if($KEY !== $this->NODE_KEY){
      if (($this->NODE_ADMIN && $KEY !== $this->ADMIN_PASS) || !$this->NODE_ADMIN) {
        $this->writeFile('error.log', 'ERROR KEY.');
        if ($this->NODE_REPORT){
          mail($this->MAIL, 'NODESHARED->ERROR: '.$this->DAEMON, 'ERROR KEY.');
        }
        return $this->report(self::$ERROR);
      }
    }

    $node_pid = @intval(file_get_contents($this->NODE_DIR_PID.'/'.$this->DAEMON));

    if($node_pid === 0){
      return $this->report(self::$NORUNNING);
    }

    if (execute($this->PATH_BIN.'/pid.py', $node_pid, true) === 'False'){
      if ($this->NODE_WATCH === 1){
        $this->writeFile('error.log', 'DOWN APP SERVER IN PID: '.$node_pid.'.');
        if ($this->NODE_REPORT){
          mail($this->MAIL, 'NODESHARED->ERROR: '.$this->DAEMON, 'DOWN APP SERVER IN PID: '.$node_pid.'.');
        }
      }else{
        $this->writeFile('access.log', 'APP STOP IN PID: '.$node_pid.'.');
      }
      @file_put_contents($this->NODE_DIR_PID.'/'.$this->DAEMON, '', LOCK_EX);
      return $this->report(self::$NORUNNING);
    }

    if(!$this->NODE_ADMIN && $this->NODE_TYPE === 1){
      $this->writeFile('error.log', 'DAEMON NO ACTIVE. TYPE: '.$this->NODE_TYPE.'.');
      return $this->report(self::$ERROR);
    }

    if (execute($this->PATH_BIN.'/kill.py', $node_pid, true) === 'True'){
      $this->writeFile('access.log', 'APP STOP IN PID: '.$node_pid.'.');
      @file_put_contents($this->NODE_DIR_PID.'/'.$this->DAEMON, '', LOCK_EX);
      if ($this->NODE_REPORT){
        mail($this->MAIL, 'NODESHARED->STOP: '.$this->DAEMON, 'APP STOP IN PID: '.$node_pid.'.');
      }
      return $this->report(self::$STOP, $node_pid);
    }else{
      $this->writeFile('error.log', 'ERROR STOP APP IN PID: '.$node_pid.'.');
      return $this->report(self::$ERROR, $node_pid);
    }
  }

  public function getStatus(){
    $node_pid = @intval(file_get_contents($this->NODE_DIR_PID.'/'.$this->DAEMON));
    
    if ( (execute($this->PATH_BIN.'/pid.py', $node_pid, true) === 'True') and $node_pid !== 0){
      return $this->report(self::$RUNNING, $node_pid);
    }else{
      @file_put_contents($this->NODE_DIR_PID.'/'.$this->DAEMON, '', LOCK_EX);
      return $this->report(self::$NORUNNING);
    }
  }

}

?>
