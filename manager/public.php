<?php
  require_once('core/access.php');
  writeHtaccess(Array(
    'admin' => ['^admin/(.*?)$', 'http://127.0.0.1:49998/$1'],
    'app'   => ['^node/(.*?)$',  'http://127.0.0.1:49999/$1']
  ));
?>
