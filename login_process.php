<?php
  // 1. 가입된 이메일인지 확인 (아니라면 alert)
  // 2. 가입된 이메일이라면 입력한 비밀번호가 맞는지 확인 (아니라면 alert)
  // 3. 1,2를 모두 만족한다면 로그인 완료
  require("lib/login_function.php");

  check_exist_email();

  check_passwd();

  login();
?>
