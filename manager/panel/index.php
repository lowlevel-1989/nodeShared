<?php
  require_once("../config.php");
  if(isset($_POST[pass])){
    $pass = $_POST[pass];
    if ($pass === getenv('NODE_PASS')){
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#login').on('submit', function(event) {
        var data = $(this).serialize();
        $.ajax({
          type : 'POST',
          data : data,
          dataType: 'jsonp',
          success : function(response) {
            console.log(response);
          }
        });
        event.preventDefault();
      });
    });
  </script>
<?php
    }
  }
?>

<form method="post" id="login">
  <input type="hidden"   name="daemon" value="admin" />
  <input type="hidden"   name="exec"   value="start" />
  <input type="password" name="pass" />
  <input type="submit" />
</form>
