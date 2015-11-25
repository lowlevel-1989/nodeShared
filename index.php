<?php
	require_once("node.php");

  define("NODE_DIR", "/home/formatcom/node");
  define("NODE_PORT", 49999);
  define("NODE_PID_DIR", "/home/formatcom/node/pid");
  define("ADMIN_PASS", "12345Admin");

	$Node = new Node(NODE_DIR, NODE_PORT, NODE_PID_DIR, ADMIN_PASS);

  if (isset($_REQUEST["exec"]) && isset($_REQUEST["pass"])){

    $exec = strtolower($_REQUEST["exec"]);
    $pass = $_REQUEST["pass"];

    if(isset($_REQUEST["file"])) $file = $_REQUEST["file"];
    else $file = 'undefined';

    switch ($exec) {
      case "start":
        echo $Node->start($file, $pass);
        break;
      case "stop":
        echo $Node->stop($pass);
        break;
    }
  }
?>
