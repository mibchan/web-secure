<?php
require("lib/reply_function.php");

if (empty($_GET['board'])) {
  delete_freeboard_comment();
} else {
  delete_infoboard_comment();
}






?>
