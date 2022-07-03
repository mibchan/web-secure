<?php
// require("lib/connectdb.php");
require("lib/modify_function.php");

session_exist();

if (empty($_GET['board'])) {
  modify_freeboard();
} else {
  modify_infoboard();
}
?>
