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
	</head>

	<body style="width: 1300px; margin: auto; margin-top: 3cm;">
	
    	<h1>수정</h1>
    	<hr>
	
    	<div id="insert_form">
    		<table id="input_area">
    			<tr>
    				<td>구분</td>
    				<td>
    					<select id="td1" >
    						<option disabled selected style="display: none;"><?=$load_val['info_division']?></option>
    						<option value="유지보수">유지보수</option>
    						<option value="문의사항">문의사항</option>
    					</select>
    				</td>
    			<tr>
    				<td>작성자</td>
    				<td>
    					<input type="text" id="td2" value="<?=$load_val['info_name']?>">
    				</td>
    			</tr>
    			<tr>
    				<td>분류</td>
    				<td>
    					<input type="radio" id="홈페이지" name="td3" value="홈페이지" <?php if ($load_val['info_cate'] == "홈페이지"){echo "checked";}?>>
    					<label for="홈페이지">홈페이지</label>
    					<input type="radio" id="네트워크" name="td3" value="네트워크" <?php if ($load_val['info_cate'] == "네트워크"){echo "checked";}?>>
    					<label for="네트워크">네트워크</label>
    					<input type="radio" id="서버" name="td3" value="서버" <?php if ($load_val['info_cate'] == "서버"){echo "checked";}?>>
    					<label for="서버">서버</label>
					</td>
    			</tr>
    			<tr>
    				<td>고객 유형</td>
    				<td>
    					<input type="checkbox" id="호스팅" value="호스팅" name="td4">
    					<label for="호스팅">호스팅</label>
    					<input type="checkbox" id="유지보수" value="유지보수" name="td4">
    					<label for="유지보수">유지보수</label>
    					<input type="checkbox" id="서버 임대" value="서버 임대" name="td4">
    					<label for="서버 임대">서버 임대</label>
    					<input type="checkbox" id="기타" value="기타" name="td4">
    					<label for="기타">기타</label>
    				</td>
    			</tr>
    			<tr>
    				<td>제목</td>
    				<td>
    					<input type="text" id="td5" value="<?=$load_val['info_title']?>">
    				</td>
    			</tr>
    			<tr>
    				<td>내용</td>
    				<td>
    					<textarea id="td6" ><?=$load_val['info_content']?></textarea>
    				</td>
    			</tr>
    			<tr>
    				<td>첨부파일</td>
    				<td id="attach_input">
    					<input type="text" value="<?=$load_val['file_name'] ?>" disabled>
    					<input id="file_display" type="file" value="찾아보기">
    					<label for="file_display">찾아보기</label>
    				</td>
    		</table>
    		
			<div style="float: right;">
				<button id="save" type="button" >저장</button>
				<button type="button" onclick="location.href='list.php'">취소</button>
			</div>
    	</div>
	</body>

</html>