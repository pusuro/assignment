<?php
    require_once 'con_query_function.php';

    $file_num = $_GET['download_num'];
    
    $find_file_query = con_query("select * from file_manager where num = $file_num");
    
    $find_file_result = mysqli_fetch_array($find_file_query);
    
    $file_dir = '../upload_file/';
    
    if (isset($find_file_result)) {
        $file_name = $find_file_result['file_name'];
        
        $file_addr = $file_dir.$file_name;
        
        header("Content-Type:application/octet-stream");
        header("Content-Disposition:attachment;filename=$file_name");
        header("Content-Transfer-Encoding:binary");
        header("Content-Length:".filesize($file_addr));
        
        $fopen = fopen($file_addr, "r");
        print fread($fopen, filesize($file_dir.$file_name));
        
    }
?>