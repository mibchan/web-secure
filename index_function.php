<?php

// --------------- 페이지의 상단을 보여준다.  --------------- //
function page_top() {
  session_start();
  if (isset($_SESSION['nickname'])) { ?>
    <h1><a href="index.php">Web Project</a></h1>
    <ul>
        <li><?=$_SESSION['nickname']?>님 환영합니다.</li>
        <li><a href="logout.php">로그아웃</a></li>
    </ul>
    <p class="board_navigate"><a href="index.php">자유게시판</a>&ensp;
    <a href="index.php?board=info">정보게시판</a></p>
    <form action = "search.php">
      <select name="category">
        <option value="total">전체</option>
        <option value="freeboard">자유게시판</option>
        <option value="infoboard">정보게시판</option>
        <option value="title">제목</option>
        <option value="description">내용</option>
      </select>
      <input type="text" name="search" size="40" required>
      <button>검색</button>
    </form>
<?php if(empty($_GET['board'])) { ?>
      <h2>자유게시판</h2>
<?php } else { ?>
      <h2>정보게시판</h2>
<?php } ?>

<?php }  else { ?>
  <h1><a href="logout.php">Web Project</a></h1>
  <ul>
      <li><a href="signup.php">회원가입</a></li>
      <li><a href="login.php">로그인</a></li>
  </ul>
  <p class="board_navigate"><a href="index.php">자유게시판</a>&ensp;
  <a href="index.php?board=info">정보게시판</a></p>
  <form action = "search.php">
    <select name="category">
      <option value="total">전체</option>
      <option value="freeboard">자유게시판</option>
      <option value="infoboard">정보게시판</option>
      <option value="title">제목</option>
      <option value="description">내용</option>
    </select>
    <input type="text" name="search" size="40" required>
    <button>검색</button>
  </form>
<?php if(empty($_GET['board'])) { ?>
      <h2>자유게시판</h2>
<?php } else { ?>
      <h2>정보게시판</h2>
<?php }
      }
  }
 ?>

<?php
// --------------- 글쓰기 버튼. 로그인을 했는지 확인. 로그인 했다면 글쓰기 페이지로 이동.  --------------- //
function write_button() {
if (isset($_SESSION['nickname']))
{
    if (empty($_GET['board']))
    { ?>
      <form action="write.php">
        <p><input type="submit" value="글 작성"></p>
      </form>
<?php }
    else
    {   ?>
      <form action="write.php">
        <input type="hidden" name="board" value="<?=$_GET['board']?>">
        <p><input type="submit" value="글 작성"></p>
      </form>
<?php  }
}
else { ?>
    <form action="logout.php">
      <p><input type="submit" value="글 작성" onclick="alert('로그인 후 이용해주세요') "></p>
    </form>
<?php }
} ?>

<?php
// --------------- 데이터 베이스의 자유게시판 테이블을 보여준다.  --------------- //
function show_freeboard() {
    require('lib/connectdb.php');
    $sql = mysqli_query($conn, "select * from (select @rownum := @rownum + 1 as row_num, t.*
    from board t,(select @rownum := 0) tmp order by num asc)sub order by sub.row_num desc");
    while($board = $sql->fetch_array())
    {
       $title = $board['title'];
       if(strlen($title)>30) {
           $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
      }  ?>
      <tbody>
        <tr>
          <td width="70"><?=$board['row_num']?></td>
          <td width="500"><a href="read.php?num=<?=$board['num']?>"><?=$board['title']?></a></td>
          <td width="120"><?=$board['nickname']?></td>
          <td width="100"><?=$board['created']?></td>
          <td width="100"><?=$board['view']; ?></td>
          <td width="100"><?=$board['reco']?></td>
        </tr>
      </tbody>
      <?php }
} ?>

<?php
// --------------- 데이터 베이스의 정보게시판 테이블을 보여준다.  --------------- //
function show_infoboard() {
    require('lib/connectdb.php');
    $sql = mysqli_query($conn, "select * from (select @rownum := @rownum + 1 as row_num, t.*
    from board2 t,(select @rownum := 0) tmp order by num asc)sub order by sub.row_num desc");
    while($board = $sql->fetch_array())
    {
       $title = $board['title'];
       if(strlen($title)>30) {
           $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
      }  ?>
      <tbody>
        <tr>
          <td width="70"><?=$board['row_num']?></td>
          <td width="500"><a href="read.php?board=<?=$_GET['board']?>&num=<?=$board['num']?>"><?=$board['title']?></a></td>
          <td width="120"><?=$board['nickname']?></td>
          <td width="100"><?=$board['created']?></td>
          <td width="100"><?=$board['view']; ?></td>
          <td width="100"><?=$board['reco']?></td>
        </tr>
      </tbody>
      <?php }
} ?>
