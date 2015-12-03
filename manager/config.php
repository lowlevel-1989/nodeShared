<?php
  require_once("core/node.php");
  define("ADMIN_PASS", "12345Admin");

  $PATH = Array(
    "node" => "/home/formatcom/node"
  );

  $DAEMONS = Array(
    "admin" => new Node("Admin", NODE_DIR, "panel/server/index.js", ADMIN_PASS),
    "app"   => new Node("App", NODE_DIR, "/home/formatcom/index.js", ADMIN_PASS)
  );
 ?>
