<?php
require("lib/write_function.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>webproject</title>
  </head>
  <body>
    <?php
    if (empty($_GET['board'])) {
      write_free_button();
    } else {
      write_info_button();
    }
    ?>

  </body>
</html>
