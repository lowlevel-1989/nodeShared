<?php
  require_once('core/access.php');
  writeHtaccess(Array(
    'app' => ['^node/(.+?)$', 'http://127.0.0.1:49999/$1']
  ));
?>
