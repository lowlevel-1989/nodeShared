<?php
  function writeHtaccess($ACCESS, $EXCLUDE=Array()) {
    $buffer = fopen('../.htaccess', 'w+');
    fwrite($buffer, "Options -Multiviews\n");
    fwrite($buffer, "Options -Indexes\n\n");
    fwrite($buffer, "RewriteEngine On\n");
    foreach ($ACCESS as $key => $value) {
      if ($key === 'root'){
        foreach ($EXCLUDE as $index => $path) {
          fwrite($buffer, "RewriteCond %{REQUEST_FILENAME} !/$path*\n");
        }  
        fwrite($buffer, "RewriteCond %{REQUEST_FILENAME} !/manager*\n");
      }
      fwrite($buffer, "RewriteRule $value[0] $value[1] [P]\n");
    }
    fclose($buffer);
  }
?>
