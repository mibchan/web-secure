<?php
// require("lib/index_function.php");
require('lib/search_function.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>webproject</title>
  <link rel="stylesheet" href="style/index.css">
</head>
<body>

<!--- - - - - - 페이지 상단  -  - - - - - - - -->
<?php
    page_search_top();

?>
<!--- - - - - - 게시판 글 목록 - - - - - - - - -->
  <table class="board">
  <thead>
      <tr>
          <th width="70">번호</th>
            <th width="300">제목</th>
            <th width="120">글쓴이</th>
            <th width="300">작성일</th>
            <th width="100">조회수</th>
            <th width="100">추천수</th>
        </tr>
    </thead>

<?php
$category = $_GET['category'];
if ($category === 'total') {
  search_total();
} elseif ($category === 'freeboard') {
  search_freeboard();
} elseif ($category === 'infoboard') {
  search_infoboard();
} elseif ($category === 'title') {
  search_title();
} elseif ($category === 'description') {
  search_description();
}
?>
    </table>


</body>
</html>
