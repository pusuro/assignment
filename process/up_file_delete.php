<?php
    require_once 'con_query_function.php';
  
    $file_name = $_POST['file_name'];
    
    $file_delete_query = con_query("DELETE FROM file_manager WHERE file_name = '$file_name'");
    
    if($file_delete_query){
        echo "파일 삭제가 완료 됐습니다.";
    }else{
        echo "파일 삭제 도중 문제가 발생 했습니다.";
    }
?>