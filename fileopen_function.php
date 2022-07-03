<?php

// --------------- 업로드 된 파일을 클릭하면 다운로드가 진행된다.(자유게시판) --------------- //
function fileopen_freeboard() {
  require('lib/connectdb.php');
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $sql = "select * from board where num=$num";
  $array = mysqli_query($conn, $sql);
  $board = mysqli_fetch_array($array);
  $file = $board['file'];
  $file_dir = 'C:\Bitnami\wampstack-8.1.5-0\apache2\htdocs\upload\\';
  $file_location = $file_dir.$file;
  $file_size = filesize($file_location);
  $real_filename = urldecode("$file");    // 한글이름 깨지지 않도록 사용

  // ----------- header 공부할 것! ----------- //
  header('Content-Type: application/x-octetstream');
  header('Content-Length: '.$file_size);
  header('Content-Disposition: attachment; filename='.$real_filename);
  header('Content-Transfer-Encoding: binary');

  $fp = fopen($file_location, "r");
  fpassthru($fp);
  fclose($fp);
}

// --------------- 업로드 된 파일을 클릭하면 다운로드가 진행된다.(정보게시판) --------------- //
function fileopen_infoboard() {
  require('lib/connectdb.php');
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $sql = "select * from board2 where num=$num";
  $array = mysqli_query($conn, $sql);
  $board = mysqli_fetch_array($array);
  $file = $board['file'];
  $file_dir = 'C:\Bitnami\wampstack-8.1.5-0\apache2\htdocs\upload\\';
  $file_location = $file_dir.$file;
  $file_size = filesize($file_location);
  $real_filename = urldecode("$file");    // 한글이름 깨지지 않도록 사용

    // ----------- header 공부할 것! ----------- //
  header('Content-Type: application/x-octetstream');
  header('Content-Length: '.$file_size);
  header('Content-Disposition: attachment; filename='.$real_filename);
  header('Content-Transfer-Encoding: binary');

  $fp = fopen($file_location, "r");
  fpassthru($fp);
  fclose($fp);
}
?>
