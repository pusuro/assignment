<?php
    require_once 'process/con_query_function.php';

    $now_page = isset($_GET['list_page']) ? $_GET['list_page'] : 1; // 기본값 1
    $count_per_page = 10;
    
    $total_count_query = con_query("SELECT COUNT(*) FROM information");
    $total_count_array = mysqli_fetch_array($total_count_query);
    $total_count = $total_count_array[0];
    
    $total_page = ceil($total_count / $count_per_page);
    
    $start = ($now_page - 1) * $count_per_page; // 페이지의 시작 인덱스
    
?>