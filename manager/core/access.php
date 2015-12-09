<?php
  function writeHtaccess($ACCESS) {
    $buffer = fopen('./htaccess', 'a+');
    fwrite($buffer, "Options -Indexes\r\r");
    fwrite($buffer, "RewriteEngine On\r");
    foreach ($ACCESS as $key => $value) {
      fwrite($buffer, "RewriteRule $value[0] $value[1] [P]\r");
    }
    fclose($buffer);
  }
?>
