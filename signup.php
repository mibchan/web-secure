<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>webproject</title>
  </head>
  <body>
    <h1><a href=index.php>Web Project</a></h1>
    <h2>Sign up</h2>
    <form action="signup_process.php" method="post">
      <p><input type="email" name="email" placeholder="이메일" maxlength="40" required></p>
      <p><input type="password" name="passwd" placeholder="비밀번호" minlength="8" maxlength="20" required></p>
      <p><input type="password" name="checkpasswd" placeholder="비밀번호 확인" minlength="8" maxlength="20" required></p>
      <p><input type="text" name="nickname" placeholder="사용할 닉네임" maxlength="15" required></p>
      <p><input type="submit" value="다음">
    </form>
    <p>비밀번호는 최소 8글자 최대 20글자</p>
    <p>닉네임은 최대 15글자</p>
  </body>
</html>
