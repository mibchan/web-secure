<?php
// --------------- 댓글 입력 폼  --------------- //
function comment_form() {
  if(empty($_GET['board'])) { ?>
    <!--  $_GET['board'] 없을 때 (freeboard)-->
    <h3>댓글</h3>
    <form action="reply_write_process.php" method="post">
      <input type="hidden" name="num" value="<?=$_GET['num']?>">
      <p><textarea cols="120" rows="3" name="comment" placehoder="내용" required maxlength="300"></textarea></p>
      <p><input type="submit" value="입력">
    </form>
  <?php } else{ ?>
    <!--  $_GET['board'] 있을 때 (infoboard)-->
    <h3>댓글</h3>
    <form action="reply_write_process.php" method="post">
      <input type="hidden" name="num" value="<?=$_GET['num']?>">
      <input type="hidden" name="board" value="<?=$_GET['board']?>">
      <p><textarea cols="120" rows="3" name="comment" placehoder="내용" required maxlength="300"></textarea></p>
      <p><input type="submit" value="입력">
    </form>
  <?php }
}

// --------------- 댓글 작성을 눌렀을 때 로그인 여부 확인 및 작성(자유게시판)  --------------- //
function write_freeboard_comment() {
  session_start();
  require("lib/connectdb.php");
  if (empty($_SESSION['nickname'])) {
    echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
    echo "<script>window.location = \"logout.php\"</script>";
  } else {
    $nickname = $_SESSION['nickname'];
    $num = $_POST['num'];
    $comment = $_POST['comment'];
    $comment = mysqli_real_escape_string($conn,$comment);
    $comment = htmlspecialchars($comment);
    $sql = "insert into reply
            (num,kind,comment,created,nickname)
            values('{$num}','free','{$comment}',now(),'{$nickname}')";
    mysqli_query($conn, $sql);
    echo "<script>alert(\"성공적으로 작성되었습니다.\")</script>";
    echo "<script>window.location = \"read.php?num=$num\"</script>";;
  }
}

// --------------- 댓글 작성을 눌렀을 때 로그인 여부 확인 및 작성(정보게시판)  --------------- //
function write_infoboard_comment() {
  session_start();
  require("lib/connectdb.php");
  if (empty($_SESSION['nickname'])) {
    echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
    echo "<script>window.location = \"logout.php\"</script>";
  } else {
    $nickname = $_SESSION['nickname'];
    $num = $_POST['num'];
    $comment = $_POST['comment'];
    $comment = mysqli_real_escape_string($conn, $comment);
    $comment = htmlspecialchars($comment);
    $sql = "insert into reply
            (num,kind,comment,created,nickname)
            values('{$num}','info','{$comment}',now(),'{$nickname}')";
    mysqli_query($conn, $sql);
    echo "<script>alert(\"성공적으로 작성되었습니다.\")</script>";
    echo "<script>window.location = \"read.php?board=info&num=$num\"</script>";
  }
}
?>

<?php
// --------------- 댓글 작성 시점을 기준으로 정렬해 보여준다(자유게시판)  --------------- //
function show_freeboard_comment() {
    require('lib/connectdb.php');
    $num = $_GET['num'];
    $num = mysqli_real_escape_string($conn, $num);
    $sql = mysqli_query($conn, "select * from reply where kind='free' and num='{$num}' order by created");
    while($reply = $sql->fetch_array())
    {
       $num = $reply['num'];
       $nickname = $reply['nickname'];
       $created = $reply['created'];
       $comment = $reply['comment'];
       $reply_num = $reply['reply_num'];
       ?>
       <div class="reply_read_box">
         <p><div class="reply_nickname"><?=$nickname?></div><div class="reply_created"><?=$created?></div></p>

         <div class="comment"><p><?=$comment?></p></div>
         <div class="reply_bottom"><a href="reply_modify_process.php?num=<?=$num?>&reply_num=<?=$reply['reply_num']?>">[수정]</a>&ensp;
         <a href="reply_delete_process.php?reply_num=<?=$reply['reply_num']?>">[삭제]</a></div>
       </div>
<?php    }
}
?>

<?php
// --------------- 댓글 작성 시점을 기준으로 정렬해 보여준다(정보게시판)  --------------- //
function show_infoboard_comment() {
    require('lib/connectdb.php');
    $num = $_GET['num'];
    $num = mysqli_real_escape_string($conn, $num);
    $sql = mysqli_query($conn, "select * from reply where kind='info' and num='{$num}' order by created");
    while($reply = $sql->fetch_array())
    {
       $num = $reply['num'];
       $nickname = $reply['nickname'];
       $created = $reply['created'];
       $comment = $reply['comment'];
       $reply_num = $reply['reply_num'];
       ?>
       <div class="reply_read_box">
         <p><div class="reply_nickname"><?=$nickname?></div><div class="reply_created"><?=$created?></div></p>

         <div class="comment"><p><?=$comment?></p></div>
         <div class="reply_bottom"><a href="reply_modify_process.php?board=info&num=<?=$num?>&reply_num=<?=$reply['reply_num']?>">[수정]</a>&ensp;
         <a href="reply_delete_process.php?board=info&reply_num=<?=$reply['reply_num']?>">[삭제]</a></div>
       </div>
<?php    }
}
?>
<?php

// --------------- 로그인 여부 확인 및 작성자 일치 확인 후 댓글 삭제(자유게시판)  --------------- //
function delete_freeboard_comment() {
  session_start();
  require("lib/connectdb.php");
  $reply_num = $_GET['reply_num'];
  $reply_num = mysqli_real_escape_string($conn, $reply_num);
  $sql1 = "select * from reply where reply_num='{$reply_num}'";
  $array = mysqli_query($conn, $sql1);
  $reply = mysqli_fetch_array($array);
  $reply_num = $reply['reply_num'];
  $nickname = $reply['nickname'];
  $num = $reply['num'];
  if (empty($_SESSION['nickname'])) {
    echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
    echo "<script>window.location = \"logout.php\"</script>";
  } else if ($_SESSION['nickname'] != $nickname) {
    echo "<script>alert(\"작성자가 아닙니다.\")</script>";
    echo "<script>window.location = \"read.php?num=$num\"</script>";
  } else {
    $sql2 = "delete from reply where reply_num=$reply_num";
    mysqli_query($conn, $sql2);
    echo "<script>alert(\"성공적으로 삭제되었습니다.\")</script>";
    echo "<script>window.location = \"read.php?num=$num\"</script>";
  }
}

// --------------- 로그인 여부 확인 및 작성자 일치 확인 후 댓글 삭제(정보게시판)  --------------- //
function delete_infoboard_comment() {
  session_start();
  require("lib/connectdb.php");
  $board = $_GET['board'];
  $reply_num = $_GET['reply_num'];
  $reply_num = mysqli_real_escape_string($conn, $reply_num);
  $sql1 = "select * from reply where reply_num='{$reply_num}'";
  $array = mysqli_query($conn, $sql1);
  $reply = mysqli_fetch_array($array);
  $reply_num = $reply['reply_num'];
  $nickname = $reply['nickname'];
  $num = $reply['num'];
  if (empty($_SESSION['nickname'])) {
    echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
    echo "<script>window.location = \"logout.php\"</script>";
  } else if ($_SESSION['nickname'] != $nickname) {
    echo "<script>alert(\"작성자가 아닙니다.\")</script>";
    echo "<script>window.location = \"read.php?board=info&num=$num\"</script>";
  } else {
    $sql2 = "delete from reply where reply_num=$reply_num";
    mysqli_query($conn, $sql2);
    echo "<script>alert(\"성공적으로 삭제되었습니다.\")</script>";
    echo "<script>window.location = \"read.php?board=info&num=$num\"</script>";
  }
}
?>


<?php
// --------------- 댓글 수정 버튼을 눌렀을 때 그 댓글의 자리에 수정 폼이 나타난다.  --------------- //
function show_modify_comment() {
    require('lib/connectdb.php');
    if(empty($_GET['board'])) {
      $number = mysqli_real_escape_string($conn, $_GET['num']);
      $sql = mysqli_query($conn, "select * from reply where kind='free' and num='{$number}' order by created");
    } else {
      $sql = mysqli_query($conn, "select * from reply where kind='info' and num='{$number}' order by created");
    }
    while($reply = $sql->fetch_array())
    {
       $num = $reply['num'];
       $nickname = $reply['nickname'];
       $created = $reply['created'];
       $comment = $reply['comment'];
       $reply_num = $reply['reply_num'];
       // url의 reply_num이랑 $reply_num이랑 같으면
       if ($_GET['reply_num'] === $reply_num) { ?>
         <div class="reply_read_box">
           <form action="reply_modify_process2.php" method="post">
           <input type="hidden" name="reply_num" value="<?=$reply_num?>">
           <p><textarea cols="120" rows="3" name="comment" placehoder="내용" required maxlength="300"><?=$reply['comment']?></textarea></p>
           <p><input type="submit" value="수정">
           </form>
         </div>
<?php  } else { ?>
          <div class="reply_read_box">
            <p><div class="reply_nickname"><?=$nickname?></div><div class="reply_created"><?=$created?></div></p>
            <div class="comment"><p><?=$comment?></p></div>
            <div class="reply_bottom"><a href="reply_modify_process.php?reply_num=<?=$reply['reply_num']?>">[수정]</a>&ensp;
            <a href="reply_delete_process.php?reply_num=<?=$reply['reply_num']?>">[삭제]</a></div>
          </div>
<?php  }
      }
} ?>

<?php
// --------------- 수정 버튼을 눌렀을 때 로그인 여부 확인 및 작성자 일치 여부 확인 후 수정 폼 보여줌  --------------- //
function read_modify_freeboard() {
// require("lib/reply_function.php");
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
         $reply_num = mysqli_real_escape_string($conn, $_GET['reply_num']);
         $sql1 = "select * from reply where reply_num='{$reply_num}'";
         $array = mysqli_query($conn, $sql1);
         $reply = mysqli_fetch_array($array);
         $reply_num = $reply['reply_num'];
         $nickname = $reply['nickname'];
         $num = $reply['num'];
         if (empty($_SESSION['nickname'])) {
           echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
           echo "<script>window.location = \"logout.php\"</script>";
         } else if ($_SESSION['nickname'] != $nickname) {
           echo "<script>alert(\"작성자가 아닙니다.\")</script>";
           echo "<script>window.location = \"read.php?num=$num\"</script>";
         } ?>
        <h1><a href="index.php">Web Project</a></h1>
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
      show_modify_comment();
      comment_form(); ?>
    </div>
  </body>
</html>
<?php  } ?>

<?php
// --------------- 수정 버튼을 눌렀을 때 로그인 여부 확인 및 작성자 일치 여부 확인 후 수정 폼 보여줌  --------------- //
function read_modify_infoboard() {
require('lib/connectdb.php');
$num = $_GET['num'];
$num = mysqli_real_escape_string($num);
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
    <div id="board_read">
      <?php
               session_start();
               $reply_num = $_GET['reply_num'];
               $reply_num = mysqli_real_escape_string($conn, $reply_num);
               $sql1 = "select * from reply where reply_num='{$reply_num}'";
               $array = mysqli_query($conn, $sql1);
               $reply = mysqli_fetch_array($array);
               $reply_num = $reply['reply_num'];
               $nickname = $reply['nickname'];
               $num = $reply['num'];
               if (empty($_SESSION['nickname'])) {
                 echo "<script>alert(\"로그인 후 이용해주세요.\")</script>";
                 echo "<script>window.location = \"logout.php\"</script>";
               } else if ($_SESSION['nickname'] != $nickname) {
                 echo "<script>alert(\"작성자가 아닙니다.\")</script>";
                 echo "<script>window.location = \"read.php?board=info&num=$num\"</script>";
               } ?>
              <h1><a href="index.php">Web Project</a></h1>
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
      show_modify_comment();
      comment_form(); ?>
    </div>
  </body>
</html>
<?php }?>

<?php
// --------------- 수정 폼에서 정보를 입력받아 데이터 베이스의 댓글 테이블을 업데이트  --------------- //
function modify_comment() {
  session_start();
  require("lib/connectdb.php");
  $nickname = $_SESSION['nickname'];
  $reply_num = $_POST['reply_num'];
  $reply_num = mysqli_real_escape_string($conn, $reply_num);
  $comment = $_POST['comment'];
  $comment = mysqli_real_escape_string($conn, $comment);
  $comment = htmlspecialchars($comment);
  $sql = "select * from reply where reply_num='{$reply_num}'";
  $array = mysqli_query($conn, $sql);
  $reply = mysqli_fetch_array($array);
  $board = $reply['kind'];
  $num = $reply['num'];
  $sql2 = "update reply set comment='{$comment}' where reply_num='{$reply_num}' and nickname='{$nickname}'";
  mysqli_query($conn, $sql2);

  if($board==='free') {
    echo "<script>alert(\"성공적으로 수정되었습니다.\")</script>";
    echo "<script>window.location = \"read.php?&num=$num\"</script>";
  } else {
    echo "<script>alert(\"성공적으로 수정되었습니다.\")</script>";
    echo "<script>window.location = \"read.php?board=info&num=$num\"</script>";
  }
}

?>
