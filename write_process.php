<?php
  require("lib/write_function.php");
  
  session_exist();
  if(empty($_GET['board'])) {
    write_freeboard();
  } else {
    write_infoboard();
  }



?>
