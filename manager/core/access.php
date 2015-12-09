<?php
  function writeHtaccess($ACCESS) {
    $buffer = fopen('../.htaccess', 'w+');
    fwrite($buffer, "Options -Indexes\n\n");
    fwrite($buffer, "RewriteEngine On\n");
    foreach ($ACCESS as $key => $value) {
      fwrite($buffer, "RewriteRule $value[0] $value[1] [P]\n");
    }
    fclose($buffer);
  }
?>
