<?php 
    $mysql_host = "127.0.0.1";
    $mysql_db = "assignment";
    $mysql_id = "assignment";
    $mysql_pw = "assignment1";

    $con = mysqli_connect($mysql_host,$mysql_id,$mysql_pw,$mysql_db);

    $update_num = $_POST['update_num'];

    $info_query = mysqli_query($con,"SELECT *
                            FROM
                                information
                                LEFT JOIN
                                file_manager
                                ON
                                    information.info_num = file_manager.num
                            WHERE
                                file_manager.num = $update_num
                                OR
                                information.info_num = $update_num
                                and
                                file_manager.num IS NULL ");

    $load_val = mysqli_fetch_assoc($info_query);

    ?>

<html>
	<head>
		<link href="css/CRUD.css" rel="stylesheet">
		<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	</head>

	<body style="width: 1300px; margin: auto; margin-top: 3cm;">
	
    	<h1>수정</h1>
    	<hr>
	
    	<div id="insert_form">
			<form action="./process/update_process.php" method="post" style="display: inline-block;">
        		<table id="input_area">
            			<tr>
            				<td>구분</td>
            				<td>
            					<select id="td1" name="division">
                                    <option value="유지보수" <?php if($load_val['info_division'] == "유지보수") echo "selected"; ?>>유지보수</option>
                                    <option value="문의사항" <?php if($load_val['info_division'] == "문의사항") echo "selected"; ?>>문의사항</option>
                                </select>
            				</td>
            			<tr>
            				<td>작성자</td>
            				<td>
            					<input type="text" id="td2" name="name" value="<?=$load_val['info_name']?>">
            				</td>
            			</tr>
            			<tr>
            				<td>분류</td>
            				<td>
            					<input type="radio" id="홈페이지" name="cate" value="홈페이지" <?php if ($load_val['info_cate'] == "홈페이지") echo "checked";?>>
            					<label for="홈페이지">홈페이지</label>
            					<input type="radio" id="네트워크" name="cate" value="네트워크" <?php if ($load_val['info_cate'] == "네트워크") echo "checked";?>>
            					<label for="네트워크">네트워크</label>
            					<input type="radio" id="서버" name="cate" value="서버" <?php if ($load_val['info_cate'] == "서버") echo "checked";?>>
            					<label for="서버">서버</label>
        					</td>
            			</tr>
            			<tr>
            				<td>고객 유형</td>
            				<td>
            					<input type="checkbox" id="호스팅" value="호스팅" name="guest" <?php if ($load_val['info_guest'] == "호스팅") echo "checked";?>>
            					<label for="호스팅">호스팅</label>
            					<input type="checkbox" id="유지보수" value="유지보수" name="guest" <?php if ($load_val['info_guest'] == "유지보수") echo "checked";?>>
            					<label for="유지보수">유지보수</label>
            					<input type="checkbox" id="서버 임대" value="서버 임대" name="guest" <?php if ($load_val['info_guest'] == "서버 임대") echo "checked";?>>
            					<label for="서버 임대">서버 임대</label>
            					<input type="checkbox" id="기타" value="기타" name="guest" <?php if ($load_val['info_guest'] == "기타") echo "checked";?>>
            					<label for="기타">기타</label>
            				</td>
            			</tr>
            			<tr>
            				<td>제목</td>
            				<td>
            					<input type="text" id="td5" name="title" value="<?=$load_val['info_title']?>">
            				</td>
            			</tr>
            			<tr>
            				<td>내용</td>
            				<td>
            					<textarea id="td6" name="content"><?=$load_val['info_content']?></textarea>
            				</td>
            			</tr>
            			<tr>
            				<td>첨부파일</td>
            				<td id="attach_input">
            					<input type="text" id="file_output" name="file_output" disabled>
            					<input id="file_display" type="file" name="file_display" value="찾아보기">
            					<label for="file_display">찾아보기</label>
            				    <?php echo '<span style="margin-left : 8mm">'.$load_val['file_name'].'</span>';
            				    if(isset($load_val['file_name'])){
            					   echo '<input type="button" id="file_delete" value="삭제">';
            				    }
            					?>
            				</td>
        				</tr>
        		</table>
    		
    			<div style="float: right;">
    					<input type="hidden" name="update_num" value="<?=$load_val['info_num']?>">
    					<button id="save" type="submit" >저장</button>
    					<button type="button" onclick="location.href='list.php'">취소</button>
				</div>
			</form>
    	</div>
    	
    	<script type="text/javascript">
    		/* 첨부파일 이름 옆 input에 넣기 */
	    	$(function(){
          		$('#file_display').change(function(){
	            	var fileDisplay = $(this).val().replace("C:\\fakepath\\","");
    	        	$('#file_output').val(fileDisplay);
        	    	alert(fileDisplay);
              	});

              	$('#file_delete').click(function(){
          			alert("버튼 클릭했습니다.")
          			var test = $('#td2').val();
          			
          			$.ajax({
          					url : "./process/ajax_test.php",
          					type : "POST",
          					success : function(result){
          						alert(result);
          					}
          			})
              	});
   	 		});
   	 		
    	</script>
	</body>
</html>