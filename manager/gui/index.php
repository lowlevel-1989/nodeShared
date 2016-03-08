<?php
  require_once("../config.php");
  if(isset($_POST[key])){
    $key = $_POST[key];
    if ($key === getenv('NODE_KEY')){
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      var data = {
        "daemon": "admin",
        "exec": "start",
        "key": "<?php echo $key; ?>"
      };
      $.ajax({
        url: '/manager',
        type : 'POST',
        data : data,
        dataType: 'jsonp',
        success : function(response) {
          if (response[0].running){
            window.location='/manager/gui/admin/';
          }
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
