<?php
    require_once 'con_query_function.php';
    
    $list_num = $_POST['update_num'];
    $check_val = $_POST['division'];
    $check_name = $_POST['name'];
    
    var_dump($check_name);
    
    $update_query = con_query("select * from information where info_num = $list_num");
    
    $update_query_result =  mysqli_fetch_array($update_query);
    
?>
    