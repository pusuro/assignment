<?php
    $con = mysqli_connect("localhost","assignment","assignment1","assignment");
    
    $info_num = $_POST['info_num'];
    
    mysqli_query($con, "DELETE FROM information WHERE info_num = $info_num;");
    mysqli_query($con, "delete from file_manager where num = $info_num;");
    
    header('Location: ../list.php');
    
?>