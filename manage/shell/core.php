<?php

class Terminal{
  
  public static $BLOCKED = array('ssh', 'telnet', 'less', 'more', 'tail');
  public static $EDITOR  = array('vim', 'vi', 'nano');
  
  public $command        = '';
  public $output         = '';
  public $directory      = '';
  public $command_exec   = '';

  public function Terminal($directory){
    if ($directory) $this->directory = $directory;
    else $this->directory = getenv('NODE_HOME');
    $this->ChangeDirectory();
  }

  public function ChangeDirectory(){
    $this->directory = str_replace('~', getenv('NODE_HOME'), $this->directory);
    chdir($this->directory);
    $this->directory = getcwd();
  }
  
  public function ParseCommand(){
  
    $command_parts = explode(' ', $this->command);
    
    if(in_array('cd', $command_parts)){
      $cd_key = array_search('cd', $command_parts);
      $cd_key++;
      $this->directory = $command_parts[$cd_key];
      
      $_directory = $command_parts[$cd_key];
      
      $this->ChangeDirectory();
      $this->command = str_replace('cd '.$_directory, '', $this->command);
    }
    
    $this->command = str_replace(self::$EDITOR, 'cat', $this->command);
    
    if(in_array($command_parts[0], self::$BLOCKED)){
      $this->command = 'echo ERROR: Command not allowed';
    }
    
    $this->command_exec = $this->command . ' 2>&1';
  }
  
  public function Execute(){
    //system
    if(function_exists('system')){
      ob_start();
      system($this->command_exec);
      $this->output = ob_get_contents();
      ob_end_clean();
    }
    //passthru
    else if(function_exists('passthru')){
      ob_start();
      passthru($this->command_exec);
      $this->output = ob_get_contents();
      ob_end_clean();
    }
    //exec
    else if(function_exists('exec')){
      $this->output = exec($this->command_exec);
    }
    //shell_exec
    else if(function_exists('shell_exec')){
      $this->output = shell_exec($this->command_exec);
    }
    // no support
    else{
      $this->output = 'Command execution not possible on this system';
    }
  }

  public function Process(){
    $this->ParseCommand();
    $this->Execute();
    return $this->output;
  }


}

?>
