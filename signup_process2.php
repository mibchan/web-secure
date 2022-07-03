<?php
    require("lib/signup_function.php");
    $hash_testcode = $_POST['testcode'];
    $input = $_POST['input_testcode'];
    $hash_input = md5($input);
    
    if($hash_testcode === $hash_input) {
      create_data();
    } else {
        echo "<script>alert(\"인증번호가 바르지 않습니다.\")</script>";
        echo "<script>window.location = \"signup.php\"</script>";
    }
?>
