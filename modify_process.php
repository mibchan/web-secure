<?php
require("lib/modify_function.php");

if (empty($_GET['board'])) {
  modify_freeboard_process();
} else {
  modify_infoboard_process();
}
?>
