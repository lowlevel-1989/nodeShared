<?php require_once('../nodeShared/env.php'); ?>
<?php require_once('../nodeShared/core.php'); ?>
<?php require_once('../config.php'); ?>

<?php if (getenv('NODE_ADMIN')): ?>
  <?php if (isset($_POST['q']) or isset($_GET['login']) or isset($_POST['step'])): ?>
    <?php require_once('api.php'); ?>
  <?php else: ?>
    <!DOCTYPE html>
    <html>
      <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="assets/css/jquery.terminal.min.css" />
        <title>NodeShell V0.1.1</title>
      </head>
      <body>
        <script src="assets/js/jquery-3.1.1.min.js"></script>
        <script src="assets/js/jquery.terminal.min.js"></script>
        <script src="assets/js/app.js"></script>
      </body>
    </html>
  <?php endif; ?>
<?php else: header("HTTP/1.0 404 Not Found"); ?>
<?php endif; ?>
