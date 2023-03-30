<?php
    $mysql_host = "127.0.0.1";
    $mysql_db = "assignment";
    $mysql_id = "assignment";
    $mysql_pw = "assignment1";
    
    $con = mysqli_connect($mysql_host,$mysql_id,$mysql_pw,$mysql_db);

    function con_query($query){
        
        $mysql_host = "127.0.0.1";
        $mysql_db = "assignment";
        $mysql_id = "assignment";
        $mysql_pw = "assignment1";
        
        $con = mysqli_connect($mysql_host,$mysql_id,$mysql_pw,$mysql_db);
        
        return mysqli_query($con, $query);
    }
    
?>