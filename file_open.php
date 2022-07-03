<?php
require("lib/fileopen_function.php");
if(empty($_GET['board'])) {
  fileopen_freeboard();
} else {
  fileopen_infoboard();
}

?>
