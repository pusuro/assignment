<?php
    $con = mysqli_connect("localhost","assignment","assignment1","assignment");

    function con_query($query){
        
        $con = mysqli_connect("localhost","assignment","assignment1","assignment");
        
        return mysqli_query($con, $query);
    }
    
?>