<?php
  function writeHtaccess($HTACCESS, $ROUTER, $REDIRECT301, $EXCLUDE) {
    $buffer = fopen('../.htaccess', 'w+');
    fwrite($buffer, "Options -Multiviews\n");
    fwrite($buffer, "Options -Indexes\n\n");
    fwrite($buffer, "RewriteEngine On\n");
    foreach ($HTACCESS as $key => $value) {
      fwrite($buffer, "$value\n");
    }
    foreach ($REDIRECT301 as $key => $value) {
      fwrite($buffer, "RewriteRule ".$value[0]." ".$value[1]." [L,R=301,NC]\n");
    }
    foreach ($ROUTER as $key => $value) {
      if ($key === 'root'){
        foreach ($EXCLUDE as $index => $path) {
          fwrite($buffer, "RewriteCond %{REQUEST_FILENAME} !/".$path."*\n");
        }  
        fwrite($buffer, "RewriteCond %{REQUEST_FILENAME} !/manage*\n");
      }
      fwrite($buffer, "RewriteRule $value[0] $value[1] [P]\n");
    }
    fclose($buffer);
  }
?>
