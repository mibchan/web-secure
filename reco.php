<?php
require("lib/connectdb.php");
session_start();
// ------------------ 세션이 존재하는지 확인 --------------- //
if(empty($_SESSION['nickname'])) {
  echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
  echo "<script>window.location = \"index.php\"</script>";
} else {
// ------------------ -------------------------------------- //
$nickname = $_SESSION['nickname'];
$num = $_GET['num'];
// ------------------ 이미 추천한 글인지 확인  --------------- //
// ------------------ 이미 추천한 글이라면 경고창 띄우고 돌아가기  --------------- //
// ------------------ 아니라면 reco 테이블에 정보 추가하고 board, board2 테이블 update  --------------- //
$sql1 = "select num from reco where nickname='{$nickname}' and num='{$num}' and kind='free'";
$sql2 = "select num from reco where nickname='{$nickname}' and num='{$num}' and kind='info'";
$array1 = mysqli_query($conn, $sql1);
$array2 = mysqli_query($conn, $sql2);
$board1 = mysqli_fetch_array($array1);
$board2 = mysqli_fetch_array($array2);
$sql3 = "insert into reco
        (num,kind,nickname)
        values('{$_GET['num']}','free','{$_SESSION['nickname']}')";
$sql4 = "insert into reco
        (num,kind,nickname)
        values('{$_GET['num']}','info','{$_SESSION['nickname']}')";
$sql5 = "update board set reco = reco + 1 where num = '{$num}'";
$sql6 = "update board2 set reco = reco + 1 where num = '{$num}'";


if (empty($_GET['board'])) {
  if (empty($board1)) {
      mysqli_query($conn, $sql3);
      mysqli_query($conn, $sql5);
      echo "<script>window.location = \"read.php?num=$num\"</script>";
  } else {
    echo "<script>alert(\"추천은 한 번만 가능합니다.\")</script>";
    echo "<script>window.location = \"read.php?num=$num\"</script>";
  }
}
else {
  $board_name = $_GET['board'];
  if (empty($board2)) {
    mysqli_query($conn, $sql4);
    mysqli_query($conn, $sql6);
    echo "<script>window.location = \"read.php?board=$board_name&num=$num\"</script>";
  } else {
    echo "<script>alert(\"추천은 한 번만 가능합니다.\")</script>";
    echo "<script>window.location = \"read.php?board=$board_name&num=$num\"</script>";
  }
}
}
?>
