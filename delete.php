<?php
require("lib/delete_function.php");

if (empty($_GET['board'])) {
  delete_freeboard_process();
} else {
  delete_infoboard_process();
}
?>
