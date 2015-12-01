<?php
	header('Content-Type: application/json; charset=utf8');
	require_once("config.php");

  if (isset($_REQUEST["exec"]) && isset($_REQUEST["daemon"]) && isset($_REQUEST["pass"])){

    $exec   = strtolower($_REQUEST["exec"]);
    $name   = $_REQUEST["daemon"];
    $pass   = $_REQUEST["pass"];

		if(!isset($DAEMONS[$name])) die("{}");

    switch ($exec) {
      case "start":
        echo $DAEMONS[$name]->start($pass);
        break;
      case "status":
        echo $DAEMONS[$name]->getStatus($pass);
        break;
      case "stop":
        echo $DAEMONS[$name]->stop($pass);
        break;
    }
  }
?>
