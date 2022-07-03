<?php
// 파일 전송과정 중 발생할 수 있는 에러들 => 출처 : https://www.php.net/manual/en/features.file-upload.errors.php //
// ----------------- 파일 전송과정 중 에러를 검출하고 없다면 board 테이블에 데이터 생성 -------------------- //

// --------------- 세션의 존재 여부로 로그인 여부 확인  --------------- //
function session_exist() {
  session_start();
  if(empty($_SESSION['nickname'])) {
    echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
    echo "<script>window.location = \"logout.php\"</script>";
  }
}

// --------------- 작성 버튼(자유게시판)  --------------- //
function write_free_button() { ?>
    <form action="write_process.php" enctype="multipart/form-data" method="post">
      <input type="hidden" name="max_file_size" value="4000000">
      <p><input type="text" name="title" placeholder="제목" autofoucus required maxlength="50"></p>
      <p><textarea cols="100" rows="10" name="description" placehoder="내용" required maxlength="1000"></textarea></p>
      <p><input type="file" name="file"></p>
      <p><input type="submit" value="작성"></p>
    </form>
<?php }

// --------------- 작성 버튼(정보게시판)  --------------- //
function write_info_button() { ?>
    <form action="write_process.php?board=<?=$_GET['board']?>" enctype="multipart/form-data" method="post">
      <input type="hidden" name="max_file_size" value="4000000">
      <p><input type="text" name="title" placeholder="제목" autofoucus required maxlength="50"></p>
      <p><textarea cols="100" rows="10" name="description" placehoder="내용" required maxlength="1000"></textarea></p>
      <p><input type="file" name="file"></p>
      <p><input type="submit" value="작성"></p>
    </form>
<?php }

// --------------- 자유게시판에 글 및 파일을 업로드  --------------- //
function write_freeboard() {
  require("lib/connectdb.php");
  $deniedExts = array("php", "php3", "php4", "php5", "pht", "phtml");
  // session_start();
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
  $sql = "insert into board
          (title,description,file,nickname,created,realfile)
          values('{$title}','{$description}','{$uniq_file_name}','{$nickname}',now(),'{$file_name}')";

  switch($file_error) {
  case 0:
  mysqli_query($conn, $sql);
  echo "<script>alert(\"성공적으로 작성되었습니다.\")</script>";
  echo "<script>window.location = \"index.php\"</script>";
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
  echo "<script>window.location = \"index.php\"</script>";
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


// --------------- 정보게시판에 글 및 파일을 업로드  --------------- //
function write_infoboard() {
  // session_start();
  require("lib/connectdb.php");
  $deniedExts = array("php", "php3", "php4", "php5", "pht", "phtml");
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
  $sql = "insert into board2
          (title,description,file,nickname,created,realfile)
          values('{$title}','{$description}','{$uniq_file_name}','{$nickname}',now(),'{$file_name}')";
  $board_name = $_GET['board'];
  switch($file_error) {
  case 0:
  mysqli_query($conn, $sql);
  echo "<script>alert(\"성공적으로 작성되었습니다.\")</script>";
  echo "<script>window.location = \"index.php?board=$board_name\"</script>";
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
  echo "<script>window.location = \"index.php?board=$board_name\"</script>";
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