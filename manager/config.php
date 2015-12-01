<?php
  require_once("node.php");

  define("NODE_DIR", "/home/formatcom/node");
  define("ADMIN_PASS", "12345Admin");

  $DAEMONS = Array(
    "admin" => new Node("Admin", NODE_DIR, "panel/server/index.js", ADMIN_PASS),
    "app"   => new Node("App", NODE_DIR, "/home/formatcom/index.js", ADMIN_PASS)
  );

 ?>
