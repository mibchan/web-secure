<?php
require("lib/reply_function.php");


if (empty($_POST['board'])) {
  write_freeboard_comment();
} else {
  write_infoboard_comment();
}

?>
