<?php
// --------------- 글 수정을 눌렀을 때 로그인 여부 및 작성자가 일치하는지 확인(자유게시판).  --------------- //
function before_modify_check_freeboard() {
  session_start();
  require("lib/connectdb.php");
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $sql = "select * from board where num='{$num}'";
  $array = mysqli_query($conn, $sql);
  $board = mysqli_fetch_array($array);
  $nickname = $board['nickname'];
  if (empty($_SESSION['nickname'])) {
    echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
    echo "<script>window.location = \"logout.php\"</script>";
  } else if ($_SESSION['nickname'] != $nickname) {
    echo "<script>alert(\"작성자가 아닙니다.\")</script>";
    echo "<script>window.location = \"read.php?num=$num\"</script>";
  } else { ?>
    <h2>비밀번호를 입력하세요</h2>
    <form action ="modify_process.php?num=<?=$_GET['num']?>" method="post">
      <p><input type="password" name="passwd" placeholder="비밀번호" minlength="8" maxlength="20" required autofocus></p>
      <p><input type="submit" value="입력">
    </form>
    <?php }
}

// --------------- 글 수정을 눌렀을 때 로그인 여부 및 작성자가 일치하는지 확인(정보게시판)  --------------- //
function before_modify_check_infoboard() {
  session_start();
  require("lib/connectdb.php");
  $board_name = $_GET['board'];
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $sql = "select * from board2 where num='{$num}'";
  $array = mysqli_query($conn, $sql);
  $board = mysqli_fetch_array($array);
  $nickname = $board['nickname'];
  if (empty($_SESSION['nickname'])) {
    echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
    echo "<script>window.location = \"logout.php\"</script>";
  } else if ($_SESSION['nickname'] != $nickname) {
    echo "<script>alert(\"작성자가 아닙니다.\")</script>";
    echo "<script>window.location = \"read.php?board=$board_name&num=$num\"</script>";
  } else { ?>
      <h2>비밀번호를 입력하세요</h2>
      <form action ="modify_process.php?board=<?=$_GET['board']?>&num=<?=$_GET['num']?>" method="post">
        <p><input type="password" name="passwd" placeholder="비밀번호" minlength="8" maxlength="20" required autofocus></p>
        <p><input type="submit" value="입력">
      </form>
    <?php }
}

// --------------- 로그인 여부 확인  --------------- //
function session_exist() {
  session_start();
  if(empty($_SESSION['nickname'])) {
    echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
    echo "<script>window.location = \"index.php\"</script>";
  }
}

// --------------- 비밀번호가 일치하는지 확인하고 수정된 내용 제출(자유게시판)  --------------- //
function modify_freeboard_process() {
  session_start();
  require('lib/connectdb.php');
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $sql = "select * from board left join user on board.nickname = user.nickname where num='{$num}'";
  $array = mysqli_query($conn, $sql);
  $board = mysqli_fetch_array($array);
  $hash_passwd = md5($_POST['passwd']);
  if($board['passwd'] != $hash_passwd) {
    echo "<script>alert(\"비밀번호가 일치하지 않습니다.\")</script>";
    echo "<script>window.location = \"read.php?num=$num\"</script>";
  } else {
  $upload_dir='C:\Bitnami\wampstack-8.1.5-0\apache2\htdocs\upload\\';
  $upload_file=$upload_dir.basename($board['file']);
  ?>
  <form action="modify_process2.php?num=<?=$_GET['num']?>" enctype="multipart/form-data" method="post">
    <input type="hidden" name="max_file_size" value="4000000">
    <p><input type="text" name="title" placeholder="제목" autofoucus required maxlength="50" value="<?=$board['title']?>"></p>
    <p><textarea cols="100" rows="10" name="description" placehoder="내용" required maxlength="1000"><?=$board['description']?></textarea></p>
    <p><input type="file" name="file"></p>
    <p><input type="submit" value="작성"></p>
  </form>
<?php }
}

// --------------- 비밀번호가 일치하는지 확인하고 수정된 내용 제출(정보게시판)  --------------- //
function modify_infoboard_process() {
  session_start();
  require('lib/connectdb.php');
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $sql = "select * from board2 left join user on board2.nickname = user.nickname where num='{$num}'";
  $array = mysqli_query($conn, $sql);
  $board = mysqli_fetch_array($array);
  $board_name = $_GET['board'];
  $hash_passwd = md5($_POST['passwd']);
  if($board['passwd'] != $hash_passwd) {
    echo "<script>alert(\"비밀번호가 일치하지 않습니다.\")</script>";
    echo "<script>window.location = \"read.php?board=$board_name&num=$num\"</script>";
  } else {
  $upload_dir='C:\Bitnami\wampstack-8.1.5-0\apache2\htdocs\upload\\';
  $upload_file=$upload_dir.basename($board['file']);
  ?>

  <form action="modify_process2.php?board=<?=$_GET['board']?>&num=<?=$_GET['num']?>" enctype="multipart/form-data" method="post">
    <input type="hidden" name="max_file_size" value="4000000">
    <p><input type="text" name="title" placeholder="제목" autofoucus required maxlength="50" value="<?=$board['title']?>"></p>
    <p><textarea cols="100" rows="10" name="description" placehoder="내용" required maxlength="1000"><?=$board['description']?></textarea></p>
    <p><input type="file" name="file"></p>
    <p><input type="submit" value="작성"></p>
  </form>
<?php }
}

// --------------- 수정된 내용을 받아 업데이트(자유게시판)  --------------- //
function modify_freeboard() {
  require("lib/connectdb.php");
  $deniedExts = array("php", "php3", "php4", "php5", "pht", "phtml");
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $nickname=$_SESSION['nickname'];
  $title=$_POST['title'];
  $title=htmlspecialchars($title);
  $title=mysqli_real_escape_string($conn,$title);
  $description=$_POST['description'];
  $description=htmlspecialchars($description);
  $description=mysqli_real_escape_string($conn,$description);
  $file_name=$_FILES['file']['name'];
  $file_name = basename($file_name);
  $temp = explode(".",$file_name);
  $extension = strtolower(end($temp));
  $uniq_file_name=str_shuffle(uniqid()).$file_name;
  $file_error=$_FILES['file']['error'];
  $file_temp=$_FILES['file']['tmp_name'];
  $upload_dir='C:\Bitnami\wampstack-8.1.5-0\apache2\htdocs\upload\\';
  $upload_file=$upload_dir.$uniq_file_name;
  if(in_array($extension,$deniedExts)) {
    die($extension . " extension file is not allowed to upload.");
  } else {
  $file_upload_error = move_uploaded_file($file_temp, $upload_file);
  $sql = "update board set title='{$title}', description='{$description}', file='{$uniq_file_name}', realfile='{$file_name}' where num='{$_GET['num']}' and nickname='{$nickname}'";
  switch($file_error) {
    case 0:
    mysqli_query($conn, $sql);
    echo "<script>alert(\"성공적으로 작성되었습니다.\")</script>";
    echo "<script>window.location = \"read.php?num=$num\"</script>";
    break;
    case 1:
    echo "<script>alert(\"파일의 사이즈가 초과되었습니다.\")</script>";
    echo "<script>window.location = \"write.php\"</script>";
    break;
    case 2:
    echo "<script>alert(\"파일의 사이즈가 초과되었습니다.\")</script>";
    echo "<script>window.location = \"write.php\"</script>";
    break;
    case 3:
    echo "<script>alert(\"파일의 일부분만 전송되었습니다.\")</script>";
    echo "<script>window.location = \"write.php\"</script>";
    break;
    case 4:
    mysqli_query($conn, $sql);
    echo "<script>alert(\"성공적으로 작성되었습니다.\")</script>";
    echo "<script>window.location = \"read.php?num=$num\"</script>";
    break;
    case 6:
    echo "<script>alert(\"임시 폴더가 없습니다.\")</script>";
    echo "<script>window.location = \"write.php\"</script>";
    break;
    case 7:
    echo "<script>alert(\"디스크에 파일 쓰기를 실패했습니다.\")</script>";
    echo "<script>window.location = \"write.php\"</script>";
    break;
    case 8:
    echo "<script>alert(\"확장에 의해 파일 업로드가 중지되었습니다.\")</script>";
    echo "<script>window.location = \"write.php\"</script>";
    break;
    }
  }
}

// --------------- 수정된 내용을 받아 업데이트(정보게시판)  --------------- //
function modify_infoboard() {
  require("lib/connectdb.php");
  $deniedExts = array("php", "php3", "php4", "php5", "pht", "phtml");
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $nickname=$_SESSION['nickname'];
  $title=$_POST['title'];
  $title=htmlspecialchars($title);
  $title=mysqli_real_escape_string($conn,$title);
  $description=$_POST['description'];
  $description=htmlspecialchars($description);
  $description=mysqli_real_escape_string($conn,$description);
  $file_name=$_FILES['file']['name'];
  $file_name = basename($file_name);
  $temp = explode(".",$file_name);
  $extension = strtolower(end($temp));
  $uniq_file_name=str_shuffle(uniqid()).$file_name;
  $file_error=$_FILES['file']['error'];
  $file_temp=$_FILES['file']['tmp_name'];
  $upload_dir='C:\Bitnami\wampstack-8.1.5-0\apache2\htdocs\upload\\';
  $upload_file=$upload_dir.$uniq_file_name;
  if(in_array($extension,$deniedExts)) {
    die($extension . " extension file is not allowed to upload.");
  } else {
  $file_upload_error = move_uploaded_file($file_temp, $upload_file);
  $board_name = $_GET['board'];
  $sql = "update board2 set title='{$title}', description='{$description}', file='{$uniq_file_name}', realfile='{$file_name}' where num='{$_GET['num']}' and nickname='{$nickname}'";
  switch($file_error) {
  case 0:
  mysqli_query($conn, $sql);
  echo "<script>alert(\"성공적으로 작성되었습니다.\")</script>";
  echo "<script>window.location = \"read.php?board=$board_name&num=$num\"</script>";
  break;
  case 1:
  echo "<script>alert(\"파일의 사이즈가 초과되었습니다.\")</script>";
  echo "<script>window.location = \"write.php\"</script>";
  break;
  case 2:
  echo "<script>alert(\"파일의 사이즈가 초과되었습니다.\")</script>";
  echo "<script>window.location = \"write.php\"</script>";
  break;
  case 3:
  echo "<script>alert(\"파일의 일부분만 전송되었습니다.\")</script>";
  echo "<script>window.location = \"write.php\"</script>";
  break;
  case 4:
  mysqli_query($conn, $sql);
  echo "<script>alert(\"성공적으로 작성되었습니다.\")</script>";
  echo "<script>window.location = \"read.php?board=$board_name&num=$num\"</script>";
  break;
  case 6:
  echo "<script>alert(\"임시 폴더가 없습니다.\")</script>";
  echo "<script>window.location = \"write.php\"</script>";
  break;
  case 7:
  echo "<script>alert(\"디스크에 파일 쓰기를 실패했습니다.\")</script>";
  echo "<script>window.location = \"write.php\"</script>";
  break;
  case 8:
  echo "<script>alert(\"확장에 의해 파일 업로드가 중지되었습니다.\")</script>";
  echo "<script>window.location = \"write.php\"</script>";
  break;
  }
}
}
?>
