<?php
    $mysql_host = "127.0.0.1";
    $mysql_db = "assignment";
    $mysql_id = "assignment";
    $mysql_pw = "assignment1";
    
    $con = mysqli_connect($mysql_host,$mysql_id,$mysql_pw,$mysql_db);
    
    $info_num = $_POST['info_num'];
    
    $info_delete = mysqli_query($con, "delete from file_manager where num = $info_num;");
    var_dump($info_delete);
    if($info_delete == true){
        mysqli_query($con, "DELETE FROM information WHERE info_num = $info_num;");
        header('Location: ../list.php');
    }
    
?>