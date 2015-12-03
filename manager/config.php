<?php
  require_once("core/node.php");
  define("ADMIN_PASS", "12345Admin");

  $PATH = Array(
    "node" => "/home/formatcom/node"
  );

  // new Node('Name', 'bin', 'args')
  $DAEMONS = Array(
    "admin" => new Node("Admin", "node", "panel/server/index.js"),
    "app"   => new Node("App", "node", "/home/formatcom/index.js")
  );
 ?>
