<?php

// ----------------- 메일을 보낸다 -------------------- //
function sendemail() {
  $random = uniqid();
  global $testcode;
  $testcode = str_shuffle($random);
  global $hash_testcode;
  $hash_testcode = md5($testcode);
  $to = $_POST['email'];
  $subject = "이메일 인증";
  $message = "홈페이지에서 인증번호를 입력하세요 : $testcode";
  $headers[] = 'MIME-Version : 1.0';
  $headers[] = 'Content-type: text/html; charset=utf-8';
  $headers[] = 'From: webmaster<lbskms1026@gmail.com>';
  mail($to,$subject,$message,implode("\r\n",$headers));
}

// ----------------- 입력한 비밀번호와 비밀번호 확인 칸을 비교 -------------------- //
function checkpasswd() {
  if ($_POST['passwd'] != $_POST['checkpasswd'])
  {
    echo "<script>alert(\"비밀번호와 비밀번호 확인 값이 다릅니다.\")</script>";
    echo "<script>window.location = \"signup.php\"</script>";
    return false;
  } else {
    return true;
  }
}

// ----------------- 입력한 메일이 유효한 도메인을 사용하는지 확인 -------------------- //
function check_valid_email() {
  list($user,$domain) = explode("@",$_POST['email']);
  if(!checkdnsrr($domain,"MX")) {
    echo "<script>alert(\"이메일이 올바르지 않습니다.\")</script>";
    echo "<script>window.location = \"signup.php\"</script>";
    return false;
  } else {
    return true;
  }
}

// ----------------- 이미 가입한 이메일인지 확인 -------------------- //
function check_exist_email() {
  require("lib/connectdb.php");
  $_POST['email'] = mysqli_real_escape_string($conn, $_POST['email']);
  $sql = "select email from user where email = '{$_POST['email']}'";
  $result = mysqli_query($conn,$sql);
  if ($result -> num_rows != 0) {
    echo "<script>alert(\"사용중인 이메일입니다.\")</script>";
    echo "<script>window.location = \"signup.php\"</script>";
    return false;
  } else {
    return true;
  }
}

// ----------------- 사용중인 닉네임인지 확인 -------------------- //
function check_exist_nickname() {
  require("lib/connectdb.php");
  $_POST['nickname'] = mysqli_real_escape_string($conn, $_POST['nickname']);
  $sql = "select nickname from user where nickname = '{$_POST['nickname']}'";
  $result = mysqli_query($conn,$sql);
  if ($result -> num_rows != 0) {
    echo "<script>alert(\"사용중인 닉네임입니다.\")</script>";
    echo "<script>window.location = \"signup.php\"</script>";
    return false;
  } else {
    return true;
  }
}

// ----------------- 인증번호가 일치하다면 데이터를 생성하고 가입완료를 알린다 -------------------- //
function create_data() {
  require("lib/connectdb.php");
  $_POST['email'] = mysqli_real_escape_string($conn, $_POST['email']);
  $_POST['passwd'] = mysqli_real_escape_string($conn, $_POST['passwd']);
  $hash_passwd = md5($_POST['passwd']);
  $_POST['nickname'] = mysqli_real_escape_string($conn, $_POST['nickname']);
  $_POST['nickname'] = htmlspecialchars($_POST['nickname']);
  $sql = "insert into user (email, passwd, nickname) values('{$_POST['email']}','{$hash_passwd}','{$_POST['nickname']}')";
  $result = mysqli_query($conn,$sql);
  if($result === false) {
    echo "<script>alert(\"회원가입 과정에 문제가 발생했습니다. 관리자에게 문의해주세요.\")</script>";
    echo "<script>window.location = \"signup.php\"</script>";
  } else {
?>          <h2>축하드립니다.</h2>
            <h3>회원가입이 완료되었습니다.</h3>
            <form action="index.php">
              <input type="submit" value="홈으로">
            </form>
<?php  }
}
?>
