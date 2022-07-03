<?php
require("lib/modify_function.php");

if (empty($_GET['board'])) {
  before_modify_check_freeboard();
} else {
  before_modify_check_infoboard();
}
?>
