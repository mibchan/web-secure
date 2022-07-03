
<?php
  require('lib/signup_function.php');
  check_valid_email();   // 이메일의 도메인이 존재하는지 확인
    if (check_valid_email() != false) {
      check_exist_email();
      if (check_exist_email() != false) {
        check_exist_email();
        if(check_exist_email() != false) {
          check_exist_nickname();
          if(check_exist_nickname() != false) {
            checkpasswd();
            if(checkpasswd() != false) {
              sendemail();
          }
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>webproject</title>
  </head>
  <body>
    <h1><a href="index.php">Web Project</a></h1>
    <p><h2>인증번호 확인</h2></p>
    <p><h3>인증번호를 입력하세요</h3></p>
    <form action="signup_process2.php" method="post">
      <input type="hidden" name="email" value="<?=$_POST['email']?>">
      <input type="hidden" name="passwd" value="<?=$_POST['passwd']?>">
      <input type="hidden" name="nickname" value="<?=$_POST['nickname']?>">
      <input type="hidden" name="testcode" value="<?=$hash_testcode?>">
      <p><input type="text" name="input_testcode" placeholder="인증번호를 입력하세요"></p>
      <p><input type="submit" value="확인">
    </form>
  </body>
</html>
