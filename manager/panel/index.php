<?php
  require_once("../config.php");
  if(isset($_POST[pass])){
    $pass = $_POST[pass];
    if ($pass === getenv('NODE_PASS')){
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var data = {
        "daemon": "admin",
        "exec": "start",
        "pass": <?php echo $pass; ?>
      };
      $.ajax({
        type : 'POST',
        data : data,
        dataType: 'jsonp',
        success : function(response) {
          console.log(response);
        }
      });
    });
  </script>
<?php
    }
  }
?>

<form method="post">
  <input type="password" name="pass" />
  <input type="submit" />
</form>
