<?php
// ------------------- 전체 검색 ------------------- //
function search_total() {
    require('lib/connectdb.php');
    $category = $_GET['category'];
    $search = $_GET['search'];
    $search = htmlspecialchars($search);
    $search = mysqli_real_escape_string($conn, $search);
    // echo $search;
    $sql = mysqli_query($conn, "select * from (select @rownum := @rownum + 1 as row_num, t.*
    from (select * from board where title like '%$search%' or description like '%$search%'
    union select * from board2 where title like '%$search%' or description like '%$search%' order by created desc) t,
    (select @rownum := 0) tmp order by created asc)sub order by sub.row_num desc");
    while($board = $sql->fetch_array())
    {
       $title = $board['title'];
       if(strlen($title)>30) {
           $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
      }  ?>
      <tbody>
        <tr>
          <td width="70"><?=$board['row_num']?></td>
          <?php if ($board['kind'] === 'free') { ?>
          <td width="500"><a href="read.php?num=<?=$board['num']?>&category=<?=$category?>&search=<?=$search?>"><?=$board['title']?></a></td>
<?php        } elseif ($board['kind'] === 'info') { ?>
          <td width="500"><a href="read.php?board=<?=$board['kind']?>&num=<?=$board['num']?>&category=<?=$category?>&search=<?=$search?>"><?=$board['title']?></a></td>
<?php        }?>
          <td width="120"><?=$board['nickname']?></td>
          <td width="100"><?=$board['created']?></td>
          <td width="100"><?=$board['view']; ?></td>
          <td width="100"><?=$board['reco']?></td>
        </tr>
      </tbody>

<?php         }
} ?>
<?php
// ------------------- 자유게시판 검색 ------------------- //
function search_freeboard() {
  require('lib/connectdb.php');
  $category = $_GET['category'];
  $search = $_GET['search'];
  $search = htmlspecialchars($search);
  $search = mysqli_real_escape_string($conn, $search);
  $sql = mysqli_query($conn, "select * from (select @rownum := @rownum + 1 as row_num, t.*
  from (select * from board where title like '%$search%' or description like '%$search%' order by created desc) t,
  (select @rownum := 0) tmp order by created asc)sub order by sub.row_num desc");
  while($board = $sql->fetch_array())
  {
    $title = $board['title'];
    if(strlen($title)>30) {
       $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
  }  ?>
  <tbody>
    <tr>
      <td width="70"><?=$board['row_num']?></td>
      <?php if ($board['kind'] === 'free') { ?>
      <td width="500"><a href="read.php?num=<?=$board['num']?>&category=<?=$category?>&search=<?=$search?>"><?=$board['title']?></a></td>
<?php        } elseif ($board['kind'] === 'info') { ?>
      <td width="500"><a href="read.php?board=<?=$board['kind']?>&num=<?=$board['num']?>&category=<?=$category?>&search=<?=$search?>"><?=$board['title']?></a></td>
<?php        }?>
      <td width="120"><?=$board['nickname']?></td>
      <td width="100"><?=$board['created']?></td>
      <td width="100"><?=$board['view']; ?></td>
      <td width="100"><?=$board['reco']?></td>
    </tr>
  </tbody>
  <?php }
}?>

<?php
// ------------------- 정보게시판 검색 ------------------- //
function search_infoboard() {
  require('lib/connectdb.php');
  $category = $_GET['category'];
  $search = $_GET['search'];
  $search = htmlspecialchars($search);
  $search = mysqli_real_escape_string($conn, $search);
  $sql = mysqli_query($conn, "select * from (select @rownum := @rownum + 1 as row_num, t.*
  from (select * from board2 where title like '%$search%' or description like '%$search%' order by created desc) t,
  (select @rownum := 0) tmp order by created asc)sub order by sub.row_num desc");
  while($board = $sql->fetch_array())
  {
    $title = $board['title'];
    if(strlen($title)>30) {
     $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
  }  ?>
  <tbody>
    <tr>
      <td width="70"><?=$board['row_num']?></td>
      <?php if ($board['kind'] === 'free') { ?>
      <td width="500"><a href="read.php?num=<?=$board['num']?>&category=<?=$category?>&search=<?=$search?>"><?=$board['title']?></a></td>
<?php        } elseif ($board['kind'] === 'info') { ?>
      <td width="500"><a href="read.php?board=<?=$board['kind']?>&num=<?=$board['num']?>&category=<?=$category?>&search=<?=$search?>"><?=$board['title']?></a></td>
<?php        }?>
      <td width="120"><?=$board['nickname']?></td>
      <td width="100"><?=$board['created']?></td>
      <td width="100"><?=$board['view']; ?></td>
      <td width="100"><?=$board['reco']?></td>
    </tr>
  </tbody>
  <?php }
}?>
<?php
// ------------------- 제목 검색 ------------------- //
function search_title() {
  require('lib/connectdb.php');
  $category = $_GET['category'];
  $search = $_GET['search'];
  $search = htmlspecialchars($search);
  $search = mysqli_real_escape_string($conn, $search);
  $sql = mysqli_query($conn, "select * from (select @rownum := @rownum + 1 as row_num, t.*
  from (select * from board where title like '%$search%'
  union select * from board2 where title like '%$search%' order by created desc) t,
  (select @rownum := 0) tmp order by created asc)sub order by sub.row_num desc");
  while($board = $sql->fetch_array())
  {
    $title = $board['title'];
    if(strlen($title)>30) {
       $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
  }  ?>
  <tbody>
    <tr>
      <td width="70"><?=$board['row_num']?></td>
      <?php if ($board['kind'] === 'free') { ?>
      <td width="500"><a href="read.php?num=<?=$board['num']?>&category=<?=$category?>&search=<?=$search?>"><?=$board['title']?></a></td>
<?php        } elseif ($board['kind'] === 'info') { ?>
      <td width="500"><a href="read.php?board=<?=$board['kind']?>&num=<?=$board['num']?>&category=<?=$category?>&search=<?=$search?>"><?=$board['title']?></a></td>
<?php        }?>
      <td width="120"><?=$board['nickname']?></td>
      <td width="100"><?=$board['created']?></td>
      <td width="100"><?=$board['view']; ?></td>
      <td width="100"><?=$board['reco']?></td>
    </tr>
  </tbody>
  <?php }
}?>
<?php
// ------------------- 내용 검색 ------------------- //
function search_description() {
  require('lib/connectdb.php');
  $category = $_GET['category'];
  $search = $_GET['search'];
  $search = htmlspecialchars($search);
  $search = mysqli_real_escape_string($conn, $search);
  $sql = mysqli_query($conn, "select * from (select @rownum := @rownum + 1 as row_num, t.*
  from (select * from board where description like '%$search%'
  union select * from board2 where description like '%$search%' order by created desc) t,
  (select @rownum := 0) tmp order by created asc)sub order by sub.row_num desc");
  while($board = $sql->fetch_array())
  {
    $title = $board['title'];
    if(strlen($title)>30) {
       $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
  }  ?>
  <tbody>
    <tr>
      <td width="70"><?=$board['row_num']?></td>
      <?php if ($board['kind'] === 'free') { ?>
      <td width="500"><a href="read.php?num=<?=$board['num']?>&category=<?=$category?>&search=<?=$search?>"><?=$board['title']?></a></td>
<?php        } elseif ($board['kind'] === 'info') { ?>
      <td width="500"><a href="read.php?board=<?=$board['kind']?>&num=<?=$board['num']?>&category=<?=$category?>&search=<?=$search?>"><?=$board['title']?></a></td>
<?php        }?>
      <td width="120"><?=$board['nickname']?></td>
      <td width="100"><?=$board['created']?></td>
      <td width="100"><?=$board['view']; ?></td>
      <td width="100"><?=$board['reco']?></td>
    </tr>
  </tbody>
  <?php }
}?>
<?php
// ------------------- 상단 화면 ------------------- //
function page_search_top() {
  session_start();
  if ($_GET['category'] === 'total') {
    $category = "전체";
  } elseif ($_GET['category'] === 'freeboard') {
    $category = "자유게시판";
  } elseif ($_GET['category'] === 'infoboard') {
    $category = "정보게시판";
  } elseif ($_GET['category'] === 'title') {
    $category = "제목";
  } elseif ($_GET['category'] === 'description') {
    $category = "내용";
  } else {
    die("category is not matched.");
  }
  $search = $_GET['search'];
  $search = htmlspecialchars($search);
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
    <h2>'<?=$category?>'에서 '<?=$search?>'의 검색 결과</h2>
<?php } else { ?>
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
      <h2>'<?=$category?>'에서 '<?=$search?>'의 검색 결과</h2>
<?php }
} ?>
