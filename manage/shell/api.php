<?php

  header("Access-Control-Allow-Origin: ".getenv('NODE_ACCESS'));
  header('Content-Type: application/json; charset=utf8');

  require_once('core.php');

  function _is_user($user, $pass){
    if (
      $user === getenv('NODE_ADMIN_USER') and
      $pass === getenv('NODE_ADMIN_PASS')
    ) $auth = md5($user . ':' . $pass);
    else $auth = false;
    return $auth;
  }

  function _is_auth($token){
    return strcmp(md5(getenv('NODE_ADMIN_USER') . ':' . getenv('NODE_ADMIN_PASS')), $token) === 0;
  }

  if ($_POST['user'] and $_POST['pass']){
    die(json_encode(
      array(
        'auth' => _is_user($_POST['user'], $_POST['pass']),
        'pwd'  => getenv('NODE_HOME')
      )
    ));
  }

  if ($_POST['q']){
    $is_auth = _is_auth(apache_request_headers()['Authorization']);
    if ($is_auth){

      $Terminal = new Terminal($_POST['pwd']);
      $command  = explode("&&", $_POST['q']);
      $output = '';

      foreach($command as $c){
        $Terminal->command = $c;
        $output .= $Terminal->Process();
      }

      die(json_encode(
        array('output' => $output, 'pwd' => $Terminal->directory)
      ));
    }
  }
?>
