<?php
// 입력한 비밀번호와 데이터 베이스의 비밀번호가 다르면 비밀번호가 일치하지 않습니다. board랑 user랑 합쳐야함.
// 일치한다면 데이터 베이스에서 $_GET['num'] 으로 찾아서 행 삭제.
require("lib/delete_function.php");
if(empty($_GET['board'])){
    delete_freeboard();
} else {
    delete_infoboard();
}


?>
