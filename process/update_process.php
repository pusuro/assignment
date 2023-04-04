<?php
    require_once 'con_query_function.php';

    $update_process = array(
                    'num' => mysqli_real_escape_string($con, $_POST['update_num']),
                    'name' => mysqli_real_escape_string($con, $_POST['name']),
                    'division' => mysqli_real_escape_string($con, $_POST['division']),
                    'cate' => mysqli_real_escape_string($con, $_POST['cate']),
                    'guest' => mysqli_real_escape_string($con, $_POST['guest']),
                    'title' => mysqli_real_escape_string($con, $_POST['title']),
                    'content' => mysqli_real_escape_string($con, $_POST['content']),
                    );
    $check_up = con_query("UPDATE information
                        	SET
                        		info_num= '{$update_process['num']}',
                        		info_name='{$update_process['name']}',
                        		info_division='{$update_process['division']}',
                        		info_cate='{$update_process['cate']}',
                        		info_guest='{$update_process['guest']}',
                        		info_title='{$update_process['title']}',
                        		info_content='{$update_process['content']}'
                        	WHERE info_num= {$update_process['num']}");
    
    
    
    
    
?>