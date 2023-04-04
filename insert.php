<html>
	<head>
		<link href="css/CRUD.css?after" rel="stylesheet">
		<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
	</head>

	<body style="width: 1300px; margin: auto; margin-top: 3cm;">
	
    	<h1>등록</h1>
		<hr>
	
    	<form action="process/insert_process.php" method="POST" enctype="multipart/form-data">

<?php 
    $mysql_host = "127.0.0.1";
    $mysql_db = "assignment";
    $mysql_id = "assignment";
    $mysql_pw = "assignment1";
    
    $con = mysqli_connect($mysql_host,$mysql_id,$mysql_pw,$mysql_db);

    $max_num_query = mysqli_query($con, "select MAX(info_num)+1 from information");
    
    foreach ($max_num_query as $max_num);
	
    if(empty($max_num['MAX(info_num)+1'])){
?>
				<input type="hidden" name="num" value="1">
<?php 
    }elseif (!empty($max_num['MAX(info_num)+1'])){
?>
				<input type="hidden" name="num" value="<?=$max_num['MAX(info_num)+1']?>">
<?php 
    }
?>	
				<input type="hidden" name="date" value="<?=date("Y-m-d") ?>">

        	<div id="insert_form">
        		<table id="input_area">
        			<tr>
        				<td>구분(필수)</td>
        				<td>
        					<select id="td1" name="division">
        						<option disabled selected style="display: none;" >선택해주세요</option>
        						<option value="유지보수">유지보수</option>
        						<option value="문의사항">문의사항</option>
        					</select> 
        					<span>&nbsp (유지보수, 문의사항)</span>
        				</td>
        			<tr>
        				<td>작성자(필수)</td>
        				<td>
        					<input type="text" id="td2" name="name">
        				</td>
        			</tr>
        			<tr>
        				<td>분류(필수)</td>
        				<td>
        					<input type="radio" id="홈페이지" name="cate" value="홈페이지">
        					<label for="홈페이지">홈페이지</label>
        					<input type="radio" id="네트워크" name="cate" value="네트워크">
        					<label for="네트워크">네트워크</label>
        					<input type="radio" id="서버" name="cate" value="서버">
        					<label for="서버">서버</label>
    					</td>
        			</tr>
        			<tr>
        				<td>고객 유형</td>
        				<td>
        					<input type="checkbox" id="호스팅" value="호스팅" name="guest">
        					<label for="호스팅">호스팅</label>
        					<input type="checkbox" id="유지보수" value="유지보수" name="guest">
        					<label for="유지보수">유지보수</label>
        					<input type="checkbox" id="서버 임대" value="서버 임대" name="guest">
        					<label for="서버 임대">서버 임대</label>
        					<input type="checkbox" id="기타" value="기타" name="guest">
        					<label for="기타">기타</label>
        				</td>
        			</tr>
        			<tr>
        				<td>제목(필수)</td>
        				<td>
        					<input type="text" id="td5" name="title">
        				</td>
        			</tr>
        			<tr>
        				<td>내용(필수)</td>
        				<td>
        					<textarea id="td6" name="content"></textarea>
        				</td>
        			</tr>
        			<tr>
         				<td>첨부파일</td>
        				<td id="attach_input">
        					<input id="file_output" type="text" name="file_output" disabled>
        					<input id="file_input" type="file" name="file_input">
        					<label for="file_input">찾아보기</label>
        				</td>
        		</table>
        		
    			<div style="float: right;">
    				<button type="submit">저장</button>
    				<button type="button" onclick="location.href='list.php'">취소</button>
    			</div>
        	</div>
        </form>
        
       	<script type="text/javascript">
    		$(document).ready(function(){
	    		/* 첨부파일 이름 옆 input에 넣기 */
          		$('#file_input').change(function(){
                	var fileInput = $(this).val().replace("C:\\fakepath\\","");
                	$('#file_output').val(fileInput);
                	alert(fileInput);
              	});
            });
    	</script>
	</body>
</html>


