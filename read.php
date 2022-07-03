<?php
require("lib/read_function.php");

view_count();


if(empty($_GET['board'])){
  read_freeboard();
} else {
  read_infoboard();
}



?>
