<?php

class Terminal {

  public static $BLOCKED = array('ssh', 'telnet', 'less', 'more', 'tail');
  public static $EDITOR  = array('/\bvim\b/', '/\bvi\b/', '/\bnano\b/');
  public static $MANAGE  = '/\bmanage\b/';

  public $command        = '';
  public $output         = '';
  public $clear          = false;
  public $directory      = '';
  public $command_exec   = '';

  public $HOME    = '';
  public $BIN     = '';
  public $DAEMON  = '';
  public $MANAGE_BIN = 'php ';

  function __construct($directory){

    $this->HOME   = getenv('NODE_HOME');
    chdir('..');
    $this->BIN    = getcwd().'/nodeShared';
    $this->MANAGE_BIN .= getcwd().'/index.php';
    $this->DAEMON = $this->HOME.'/daemon';

    if(!file_exists($this->DAEMON)){
      mkdir($this->DAEMON, 0755, true);
    }

    if ($directory) $this->directory = $directory;
    else $this->directory = $this->HOME;
    $this->ChangeDirectory();
  }

  public function ChangeDirectory(){
    $this->directory = str_replace('~', $this->HOME, $this->directory);
    chdir($this->directory);
    $this->directory = getcwd();
    $this->directory = str_replace($this->HOME, '~', $this->directory);
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

    $this->command = preg_replace(self::$EDITOR, 'cat', $this->command);
    $this->command = preg_replace(self::$MANAGE, $this->MANAGE_BIN, $this->command);

    if(in_array($command_parts[0], self::$BLOCKED)){
      $this->command = 'echo ERROR: Command not allowed';
    }

    $this->command_exec = $this->command . ' > ' . $this->DAEMON . '/.output 2>&1 & echo $! > '. $this->DAEMON .'/.pid';
    @file_put_contents($this->DAEMON.'/.pos', '', LOCK_EX);
    @file_put_contents($this->DAEMON.'/.boutput', '', LOCK_EX);
  }

  public function Step(){

    $_is_active = false;

    $node_pid = @intval(file_get_contents($this->DAEMON.'/.pid'));

    $_pos    = @intval(file_get_contents($this->DAEMON.'/.pos'));
    $_file   = file($this->DAEMON.'/.output');

    $_s_file = array_slice($_file, $_pos);
    $_count  = count($_s_file);

    $_output = substr(implode('', $_s_file), 0, -1);

    if ($_output == false){
      if(trim(exec('diff -q '.$this->DAEMON.'/.output '.$this->DAEMON.'/.boutput')) != ''){
        exec('cat '.$this->DAEMON.'/.output | sed -e "s/\r/\[BREAK\]/g" > '.$this->DAEMON.'/.uoutput');

        $_output = str_replace('[BREAK]', "\n\r", file_get_contents($this->DAEMON.'/.uoutput'));
        $this->clear = true;
      }
    }

    @file_put_contents($this->DAEMON.'/.pos', $_count+$_pos, LOCK_EX);
    $this->output = $_output;


    if ((exec('python '.$this->BIN.'/pid.py '.$node_pid) === 'True') and $node_pid !== 0){
      @file_put_contents($this->DAEMON.'/.boutput', @file_get_contents($this->DAEMON.'/.output'), LOCK_EX);
      $_is_active = true;
    }
    return $_is_active;

  }

  public function Execute(){
    //system
    if(function_exists('system')){
      ob_start();
      system($this->command_exec);
      ob_end_clean();
    }
    //passthru
    else if(function_exists('passthru')){
      ob_start();
      passthru($this->command_exec);
      ob_end_clean();
    }
    //exec
    else if(function_exists('exec')){
      exec($this->command_exec);
    }
    //shell_exec
    else if(function_exists('shell_exec')){
      shell_exec($this->command_exec);
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
