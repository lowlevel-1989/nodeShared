<?php
  require_once('../nodeShared/env.php');
  require_once('../nodeShared/core.php');
  require_once('../config.php');

  if (getenv('NODE_ADMIN')){
    echo "enabled cgi: "; echo php_sapi_name();
    echo "<br>";
    echo "enabled mod_rewrite: "; echo array_key_exists('HTTP_MOD_REWRITE', $_SERVER);
    echo "<br>";
    echo "enabled exec: "; echo function_exists('exec');
  }else{
    header("HTTP/1.0 404 Not Found");
  }
?>
