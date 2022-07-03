<?php

// --------------- 로그인 했는지, 로그인 한 사람과 작성자가 같은지 확인  --------------- //
function delete_freeboard_process() {
  session_start();
  require('lib/connectdb.php');
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $sql = "select * from board where num='{$num}'";
  $array = mysqli_query($conn, $sql);
  $board = mysqli_fetch_array($array);
  $nickname = $board['nickname'];
  $num = $board['num'];
  if (empty($_SESSION['nickname'])) {
    echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
    echo "<script>window.location = \"logout.php\"</script>";
  } else if ($_SESSION['nickname'] != $nickname) {
    echo "<script>alert(\"작성자가 아닙니다.\")</script>";
    echo "<script>window.location = \"read.php?num=$num\"</script>";
  }
  ?>
  <p>비밀번호를 입력하세요</p>
  <form action="delete_process.php?num=<?=$num?>" method="post">
    <p><input type="password" name="passwd" placeholder="비밀번호를 입력하세요" maxlength="20" autofocus required></p>
    <p><input type="submit" value="입력"></p>
  </form>
<?php }

// --------------- 로그인 했는지, 로그인 한 사람과 작성자가 같은지 확인  --------------- //
function delete_infoboard_process() {
  session_start();
  require('lib/connectdb.php');
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $sql = "select * from board2 where num='{$num}'";
  $array = mysqli_query($conn, $sql);
  $board = mysqli_fetch_array($array);
  $nickname = $board['nickname'];
  $num = $board['num'];
  $board_name = $_GET['board'];
  if (empty($_SESSION['nickname'])) {
    echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
    echo "<script>window.location = \"logout.php\"</script>";
  } else if ($_SESSION['nickname'] != $nickname) {
    echo "<script>alert(\"작성자가 아닙니다.\")</script>";
    echo "<script>window.location = \"read.php?board=$board_name&num=$num\"</script>";
  }
  ?>
  <p>비밀번호를 입력하세요</p>
  <form action="delete_process.php?board=<?=$_GET['board']?>&num=<?=$num?>" method="post">
    <p><input type="password" name="passwd" placeholder="비밀번호를 입력하세요" maxlength="20" autofocus required></p>
    <p><input type="submit" value="입력"></p>
  </form>
<?php }

// --------------- 입력한 비밀번호가 계정의 비밀번호와 일치한다면 삭제  --------------- //
function delete_freeboard() {
session_start();
require('lib/connectdb.php');
$num = $_GET['num'];
$num = mysqli_real_escape_string($conn, $num);
$nickname = $_SESSION['nickname'];
$sql = "select * from board left join user on board.nickname = user.nickname where num='{$num}'";
$array = mysqli_query($conn, $sql);
$board = mysqli_fetch_array($array);
$sql2 = "delete from board where num={$_GET['num']} and nickname='{$nickname}'";
$hash_passwd = md5($_POST['passwd']);
if($board['passwd'] != $hash_passwd) {
  echo "<script>alert(\"비밀번호가 일치하지 않습니다.\")</script>";
  echo "<script>window.location = \"read.php?num=$num\"</script>";
} else {
  mysqli_query($conn, $sql2);
  echo "<script>alert(\"성공적으로 삭제되었습니다.\")</script>";
  echo "<script>window.location = \"index.php\"</script>";
}
}

// --------------- 입력한 비밀번호가 계정의 비밀번호와 일치한다면 삭제  --------------- //
function delete_infoboard() {
  session_start();
  require('lib/connectdb.php');
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $board_name = $_GET['board'];
  $nickname = $_SESSION['nickname'];
  $sql = "select * from board2 left join user on board2.nickname = user.nickname where num='{$num}'";
  $array = mysqli_query($conn, $sql);
  $board = mysqli_fetch_array($array);
  $board_name = $_GET['board'];
  $sql2 = "delete from board2 where num={$_GET['num']} and nickname='{$nickname}'";
  $hash_passwd = md5($_POST['passwd']);
  if($board['passwd'] != $hash_passwd) {
    echo "<script>alert(\"비밀번호가 일치하지 않습니다.\")</script>";
    echo "<script>window.location = \"read.php?board=$board_name&num=$num\"</script>";
  } else {
      mysqli_query($conn, $sql2);
      echo "<script>alert(\"성공적으로 삭제되었습니다.\")</script>";
      echo "<script>window.location = \"index.php?board=$board_name\"</script>";
  }
}
?>
