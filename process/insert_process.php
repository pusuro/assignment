<?php 
    $con = mysqli_connect("localhost","assignment","assignment1","assignment");
    
    $insertProcess = array(
                          'name' => mysqli_real_escape_string($con, $_POST['name']),
                          'division' => mysqli_real_escape_string($con, $_POST['division']),
                          'cate' => mysqli_real_escape_string($con, $_POST['cate']),
                          'guest' => mysqli_real_escape_string($con, $_POST['guest']),
                          'title' => mysqli_real_escape_string($con, $_POST['title']),
                          'content' => mysqli_real_escape_string($con, $_POST['content']),
                          'date' => mysqli_real_escape_string($con, $_POST['date'])
    );

    var_dump($insertProcess);
    
    $sql = "insert into information
            (info_name,info_division,info_cate,info_guest,info_title,info_content,info_date,info_view)
            VALUES
            ('{$insertProcess['name']}',
             '{$insertProcess['division']}','{$insertProcess['cate']}',
             '{$insertProcess['guest']}','{$insertProcess['title']}',
             '{$insertProcess['content']}','{$insertProcess['date']}',
              0)";

    $result = mysqli_query($con, $sql);
    
    /* 파일저장 */
    echo "<br>";
    print_r($_FILES['file_input']);
    $dir = '../upload_file/';

    echo empty($_POST['file_output']);

    if($_FILES['file_input']['error'] == 0){
        $tmp_name = $_FILES['file_input']['tmp_name'];
        $name = $_FILES['file_input']['name'];
        move_uploaded_file($tmp_name, $dir.$name);
    }
    
    if($result === FALSE){
        echo "insert 실패";
    }elseif ($_FILES['file_input']['error'] != 0){
        echo "파일 저장에 문제가 발생했습니다.";
    }else{
       header('Location: ../list.php');
    }
?>