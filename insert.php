<html>
	<head>
		<link href="css/CRUD.css?after" rel="stylesheet">
		<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
	</head>

	<body style="width: 1300px; margin: auto; margin-top: 3cm;">
	
    	<h1 id="jquery">등록</h1>
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
        echo '<input type="hidden" name="num" value="1">';
    }elseif (!empty($max_num['MAX(info_num)+1'])){
        echo '<input type="hidden" name="num" value="'.$max_num['MAX(info_num)+1'].'">';
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
        					<input type="checkbox" id="호스팅" value="호스팅" name="guest[]">
        					<label for="호스팅">호스팅</label>
        					<input type="checkbox" id="유지보수" value="유지보수" name="guest[]">
        					<label for="유지보수">유지보수</label>
        					<input type="checkbox" id="서버 임대" value="서버 임대" name="guest[]">
        					<label for="서버 임대">서버 임대</label>
        					<input type="checkbox" id="기타" value="기타" name="guest[]">
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
    				<button id="insert_button" type="submit">저장</button>
    				<button type="button" onclick="location.href='list.php'">취소</button>
    			</div>
        	</div>
        </form>
        
       	<script type="text/javascript">
    		$(function(){
    		
		    	/* 아이디의 value를 가져오는 함수 */	
        		function GetVal(GV){
        			return document.getElementById(GV).value;
				}
				
		/* 유효성 검사 */
        			$('#insert_button').click(function(){
        				var td1Val = GetVal('td1');
	    /* 구분 체크 */
    	       			if(td1Val != '유지보수' && td1Val != '문의사항'){
    	       				alert("구분을 선택해 주세요.");
    	       				return false;
    	       			}
    	/* 작성자 체크 */
	       				var td2Val = GetVal('td2');
	       				if(td2Val == undefined || td2Val == null || td2Val == ''){
	       					alert("작성자는 필수 입니다.");
	       					return false;
	       				}
	    /* 분류 체크 */
	     				var td3Val = $('input[name=cate]:checked').val();
	     				if(td3Val == undefined || td3Val == null || td3Val == ''){
	     					alert("분류를 골라 주세요.")
	     					return false;
	     				}
	    /* 고객 유형 체크 */
	    				var td4Val = $('input[name=guest[]]:checked').val();
	    				if(td4Val == undefined || td4Val == null || td4Val == ''){
	     					alert(td4Val);
	     					alert("유형을 체크 해주세요.");
	     					return false;
	    				}
	   	/* 제목 체크 */
	       				var td5Val = GetVal('td5');
	       				if(td5Val == undefined || td5Val == null || td5Val == ''){
	       					alert("제목은 필수 입니다.");
	       					return false;
	       				}
		/* 내용 체크 */	    
	       				var td6Val = GetVal('td6');
	       				if(td6Val == undefined || td6Val == null || td6Val == ''){
	       					alert("내용은 필수 입니다.");
	       					return false;
	       				}
       	    		})
				
    				/* 구분(필수) 선택 시 글씨 색상 변경 */
        			$("#td1").change(function(){
        				$(this).css("color","black");
        			})
        			
    	    		/* 첨부파일 이름 옆 input에 넣기 */
              		$('#file_input').change(function(){
                    	var fileInput = $(this).val().replace("C:\\fakepath\\","");
                    	$('#file_output').val(fileInput);
                  	});
                });
    	</script>
	</body>
</html>


