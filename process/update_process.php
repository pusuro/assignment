<?php
    require_once 'con_query_function.php';
    
    $POST_guest_arr = isset($_POST['guest']) ? implode(',', $_POST['guest']) : '' ;
    
    $update_process = array(
                    'num' => mysqli_real_escape_string($con, $_POST['update_num']),
                    'name' => mysqli_real_escape_string($con, $_POST['name']),
                    'division' => mysqli_real_escape_string($con, $_POST['division']),
                    'cate' => mysqli_real_escape_string($con, $_POST['cate']),
                    'guest' => mysqli_real_escape_string($con, $POST_guest_arr),
                    'title' => mysqli_real_escape_string($con, $_POST['title']),
                    'content' => mysqli_real_escape_string($con, $_POST['content']),
                    );
    
    $update_query = con_query("UPDATE information
                            	SET
                            		info_num= '{$update_process['num']}',
                            		info_name='{$update_process['name']}',
                            		info_division='{$update_process['division']}',
                            		info_cate='{$update_process['cate']}',
                            		info_guest='{$update_process['guest']}',
                            		info_title='{$update_process['title']}',
                            		info_content='{$update_process['content']}'
                            	WHERE info_num= {$update_process['num']}");
    
    $file_update = array(
        'num' => mysqli_real_escape_string($con, $_POST['update_num']),
        'file_name' => mysqli_real_escape_string($con, $_FILES['file_display']['name']),
        'file_size' => mysqli_real_escape_string($con, $_FILES['file_display']['size'])
    );
    
    $check_file = con_query("SELECT * FROM file_manager WHERE num = ".$file_update['num']);
    $check_num = mysqli_fetch_array($check_file);
    
    if($check_num == null && $file_update['file_name'] != null){
        con_query("INSERT INTO file_manager
                    (num,file_name,file_size,file_date)
                    VALUES
                    ('{$file_update['num']}','{$file_update['file_name']}','{$file_update['file_size']}',NOW())");
    }elseif(!empty($_FILES['file_display']['name'])){
        con_query("UPDATE file_manager SET
                    num='{$file_update['num']}',
            		file_name='{$file_update['file_name']}',
            		file_size='{$file_update['file_size']}',
            		file_date=NOW()
                	WHERE num= {$file_update['num']} ");
    }
    
    $dir = '../upload_file/';
    
    if($_FILES['file_display']['error'] == 0){
        $tmp_name = $_FILES['file_display']['tmp_name'];
        $name = $_FILES['file_display']['name'];
        move_uploaded_file($tmp_name, $dir.$name);
    }
    
    if($update_query === FALSE){
        echo "update 실패";
        echo mysqli_error($con);
        echo mysqli_connect_error();
    }elseif ($_FILES['file_display']['error'] != 0 && empty($_POST['file_output']) == 0){
        echo "파일 저장에 문제가 발생했습니다.";
    }else{
        header('Location: ../list.php');
    }
?>