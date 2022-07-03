<?php

// --------------- 쿠키가 있는지 확인하고 조회수를 올린다.(쿠키는 1시간 유지)  --------------- //
function view_count() {
  require("lib/connectdb.php");
  $num = $_GET['num'];
  $num = mysqli_real_escape_string($conn, $num);
  $is_count = false;
  if (!isset($_COOKIE["board_{$num}"])) {
      setcookie("board_{$num}", $num, time()+3600);
      $is_count = true;
  }

  if ($is_count) {
    if (empty($_GET['board'])) {
      $sql = "update board set view = view + 1 where num = '{$num}'";
    } else {
      $sql = "update board2 set view = view + 1 where num = '{$num}'";
    }
    mysqli_query($conn, $sql);
  }
}

// --------------- 클릭한 글을 데이터 베이스의 테이블에서 찾아 보여준다(자유게시판)  --------------- //
function read_freeboard() {
require("lib/reply_function.php");
require('lib/connectdb.php');
$num = $_GET['num'];
$num = mysqli_real_escape_string($conn, $num);
$sql = "select * from board where num='{$num}'";
$array = mysqli_query($conn, $sql);
$board = mysqli_fetch_array($array);
$title = $board['title'];
$description = $board['description'];
$nickname = $board['nickname'];
$view = $board['view'];
$reco = $board['reco'];
$num = $board['num'];
$created = $board['created'];
$file = $board['file'];
$realfile = $board['realfile'];
$file_dir = 'C:\Bitnami\wampstack-8.1.5-0\apache2\htdocs\upload\\';
$file_location = $file_dir.$file;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>webproject</title>
    <link rel="stylesheet" href="style/read.css">
  </head>
  <body>
    <div id="board_read">
<?php
         session_start();
         if (isset($_SESSION['nickname'])) { ?>
        <h1><a href="index.php">Web Project</a></h1>
<?php    } else { ?>
        <h1><a href="logout.php">Web Project</a></h1>
<?php } ?>
        <h1>자유게시판</h1>
	      <h2><?=$board['title']?></h2>
		    <div id="user_info">
			       작성:<?=$nickname?>&ensp;&ensp;<?=$created?>
             &ensp;&ensp;조회수:<?=$view?>&ensp;&ensp;추천수:<?=$reco?>
				     <div id="bo_line"></div>
			  </div>
			  <div id="description">
				     <?php echo nl2br("$description"); ?>
		  	</div>
        <div id="file">
              <a href="file_open.php?num=<?=$num?>"><?=$realfile?></a>
        </div>
        <p>
            <form action="reco.php">
              <input type="hidden" name="num" value=<?=$_GET['num']?>>
              <input type="submit" value="추천하기">
            </form>
        </p>
	       <div id="bo_ser">
			         <p>
                <?php
                if(empty($_GET['category'])) { ?>
                  <a href="index.php">[목록으로]</a>
  <?php           } else { ?>
                  <a href="search.php?category=<?=$_GET['category']?>&search=<?=$_GET['search']?>">[목록으로]</a>
  <?php } ?>

                 <a href="modify.php?num=<?=$num?>">[수정]</a>
                 <a href="delete.php?num=<?=$num?>">[삭제]</a>
               </p>
        </div>
      </div>
      <div class="reply_container">
      <?php
      show_freeboard_comment();
      comment_form(); ?>
    </div>
  </body>
</html>
<?php }?>


<?php
// --------------- 클릭한 글을 데이터 베이스의 테이블에서 찾아 보여준다(정보게시판)  --------------- //
function read_infoboard() {
require("lib/reply_function.php");
require('lib/connectdb.php');
$num = $_GET['num'];
$num = mysqli_real_escape_string($conn, $num);
$sql = "select * from board2 where num='{$num}'";
$array = mysqli_query($conn, $sql);
$board = mysqli_fetch_array($array);
$title = $board['title'];
$description = $board['description'];
$nickname = $board['nickname'];
$view = $board['view'];
$reco = $board['reco'];
$num = $board['num'];
$created = $board['created'];
$file = $board['file'];
$realfile = $board['realfile'];
$file_dir = 'C:\Bitnami\wampstack-8.1.5-0\apache2\htdocs\upload\\';
$file_location = $file_dir.$file;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>webproject</title>
    <link rel="stylesheet" href="style/read.css">
  </head>
  <body>
    <?php
             session_start();
             if (isset($_SESSION['nickname'])) { ?>
            <h1><a href="index.php">Web Project</a></h1>
    <?php    } else { ?>
            <h1><a href="logout.php">Web Project</a></h1>
    <?php } ?>
    <div id="board_read">
        <h1>정보게시판</h1>
	      <h2><?=$board['title']?></h2>
		    <div id="user_info">
			       작성:<?=$nickname?>&ensp;&ensp;<?=$created?>
             &ensp;&ensp;조회수:<?=$view?>&ensp;&ensp;추천수:<?=$reco?>
				     <div id="bo_line"></div>
			  </div>
			  <div id="description">
				     <?php echo nl2br("$description"); ?>
		  	</div>
        <div id="file">
              <a href="file_open.php?board=<?=$_GET['board']?>&num=<?=$num?>"><?=$realfile?></a>
        </div>
        <p>
        <form action="reco.php?">
          <input type="hidden" name="board" value=<?=$_GET['board']?>>
          <input type="hidden" name="num" value=<?=$_GET['num']?>>
          <input type="submit" value="추천하기">
        </form>
        </p>
	       <div id="bo_ser">
			        <p><?php
              if(empty($_GET['category'])) { ?>
                <a href="index.php?board=<?=$_GET['board']?>">[목록으로]</a>
              <?php           } else { ?>
                <a href="search.php?category=<?=$_GET['category']?>&search=<?=$_GET['search']?>">[목록으로]</a>
              <?php } ?>
                 <a href="modify.php?board=<?=$_GET['board']?>&num=<?=$num?>">[수정]</a>
                 <a href="delete.php?board=<?=$_GET['board']?>&num=<?=$num?>">[삭제]</a>
               </p>
        </div>
      </div>
      <div class="reply_container">
      <?php
      show_infoboard_comment();
      comment_form(); ?>
    </div>
  </body>
</html>
<?php }?>
