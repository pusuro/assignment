<?php
    require_once 'con_query_function.php';
  
    $ajax = $_POST['file_name'];

    $delete_file_query = con_query("select * from information where file_name = '$ajax'");
    
    $array = mysqli_fetch_assoc($delete_file_query);
    
    echo encode($array);

?>