<?php 
    /* con_query 함수, connect($con)가 있어서 쿼리문만 입력하면 됨 */
    require_once 'process/con_query_function.php';

    $list_num = $_GET['list_num'];
    
    $read_query = con_query("select * from information where info_num = '$list_num'");
    
    $read_val = mysqli_fetch_assoc($read_query);
?>

<html>
	<head>
		<link href="css/CRUD.css?after" rel="stylesheet">
		<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
	</head>

	<body style="width: 1300px; margin: auto; margin-top: 3cm;">

    	<h1>조회</h1>
    	<hr>
    	
    	<div id="insert_form">
    		<table id="input_area">
    			<tr>
    				<td>구분</td>
    				<td><?=$read_val['info_division']?></td>
    			<tr>
    				<td>작성자</td>
    				<td><?=$read_val['info_name']?></td>
    			</tr>
    			<tr>
    				<td>분류</td>
    				<td><?=$read_val['info_cate'] ?></td>
    			</tr>
    			<tr>
    				<td>고객 유형</td>
    				<td><?=$read_val['info_guest']?></td>
    			</tr>
    			<tr>
    				<td>제목</td>
    				<td><?=$read_val['info_title']?></td>
    			</tr>
    			<tr>
    				<td>내용</td>
    				<td>
    					<pre id="td6" style="border: none; font-size: 18px;"><?=$read_val['info_content']?></pre>
    				</td>
    			</tr>
    			<tr>
    				<td>첨부파일</td>
    				<td id="attach_input">
    					<span>db 연결 후 받아오는값</span>
    					<input id="file_display" type="file" value="찾아보기">
    					<label for="file_display">다운로드</label>
    				</td>
    		</table>
    		
			<div style="float: right;">
				<form action="update.php" method="POST" style="display: inline-block;">
					<input type="hidden" name="update_num" value="<?=$read_val['info_num']?>">
					<button type="submit">수정</button>
				</form>
				<form action="process/delete_process.php" method="POST" style="display: inline-block;">
					<input type="hidden" name="info_num" value="<?=$read_val['info_num']?>">
					<button type="submit">삭제</button>
				</form>
				<button type="button" onclick="location.href='list.php'">목록</button>
			</div>
    	</div>
	</body>
</html>