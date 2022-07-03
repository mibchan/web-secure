<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>webproject</title>
  </head>
  <body>
    <h1><a href=index.php>Web Project</a></h1>
    <h2>Login</h2>
    <form action="login_process.php" method="post">
      <p><input type="email" name="email" placeholder="이메일" maxlength="40" required></p>
      <p><input type="password" name="passwd" placeholder="비밀번호" maxlength="20" required></p>
      <p><input type="submit" value="로그인">
    </form>
    <a href=signup.php>회원가입</a>
  </body>
</html>
