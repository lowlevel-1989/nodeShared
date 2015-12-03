<?php
  $URL = Array(
    "app" => ["^node/(.+?)", "http://127.0.0.1:49999/$1"]
  );
?>
<!--
Options -Indexes

RewriteEngine On
RewriteRule ^node(.*?)$  http://127.0.0.1:49998/$1 [P] # http://tudomio.com/node  -> panel del admin.
RewriteRule ^node/(.*?)$ http://127.0.0.1:49999/$1 [P] # http://tudomio.com/node/ -> app por defecto.
 -->
