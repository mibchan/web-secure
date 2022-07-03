<?php
require("lib/reply_function.php");
if (empty($_GET['board'])) {
  read_modify_freeboard();
} else {
  read_modify_infoboard();
}

?>
