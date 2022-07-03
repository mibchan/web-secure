<?php

// ----------------- 가입된 이메일인지 확인 -------------------- //
function check_exist_email() {
  require("lib/connectdb.php");
  $_POST['email'] = mysqli_real_escape_string($conn, $_POST['email']);
  $sql = "select email from user where email = '{$_POST['email']}'";
  $result = mysqli_query($conn,$sql);
  if ($result -> num_rows == 0) {
    echo "<script>alert(\"가입하지 않은 이메일입니다.\")</script>";
    echo "<script>window.location = \"login.php\"</script>";
  }
}

// ----------------- 입력한 이메일에 해당하는 비밀번호와 입력 비밀번호 값을 비교 -------------------- //
function check_passwd() {
  require("lib/connectdb.php");
  $_POST['email'] = mysqli_real_escape_string($conn, $_POST['email']);
  $_POST['passwd'] = mysqli_real_escape_string($conn, $_POST['passwd']);
  $sql = "select passwd from user where email = '{$_POST['email']}'";
  $result = mysqli_query($conn,$sql);
  $passwd_array = mysqli_fetch_array($result);
  $hash_passwd= md5($_POST['passwd']);
  if ($passwd_array['passwd'] != $hash_passwd) {
    echo "<script>alert(\"비밀번호가 다릅니다.\")</script>";
    echo "<script>window.location = \"login.php\"</script>";
  }

// ----------------- 로그인 -------------------- //
function login(){
              session_start();
              require("lib/connectdb.php");
              $_POST['email'] = mysqli_real_escape_string($conn, $_POST['email']);
              $_POST['passwd'] = mysqli_real_escape_string($conn, $_POST['passwd']);
              $hash_passwd = md5($_POST['passwd']);
              $sql = "select nickname from user where email = '{$_POST['email']}' and passwd='{$hash_passwd}'";
              $result = mysqli_query($conn,$sql);
              $nickname_array = mysqli_fetch_array($result);
              $nickname = $nickname_array['nickname'];
              $_SESSION['nickname'] = $nickname;
  ?>          <h2>로그인이 완료되었습니다.</h2>
              <form action="index.php">
                <input type="submit" value="홈으로">
              </form>
  <?php  }
}
?>
