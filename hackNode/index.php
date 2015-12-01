<?php
	header('Content-Type: application/json; charset=utf8');
	require_once("config.php");

  if (isset($_REQUEST["exec"]) && isset($_REQUEST["daemon"]) && isset($_REQUEST["pass"])){

    $exec   = strtolower($_REQUEST["exec"]);
    $daemon = $_REQUEST["daemon"];
    $pass   = $_REQUEST["pass"];

		if(!isset($DAEMONS[$daemon])) die("{}");

    switch ($exec) {
      case "start":
        echo $DAEMONS[$daemon]->start($pass);
        break;
      case "status":
        echo $DAEMONS[$daemon]->getStatus($pass);
        break;
      case "stop":
        echo $DAEMONS[$daemon]->stop($pass);
        break;
    }
  }
?>
