<?php 
    require_once 'process/con_query_function.php';

    $update_num = $_POST['update_num'];

    $info_query = con_query("SELECT *
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

    $guest_arr = explode(',', $load_val['info_guest']);

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
			<form action="./process/update_process.php" method="post" enctype="multipart/form-data" style="display: inline-block;">
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
                                <?php
                                $guest_options = array("호스팅", "유지보수", "서버 임대", "기타");
                                foreach ($guest_options as $option) {
                                    $checked = in_array($option, $guest_arr) ? "checked" : "";
                                    echo '<input type="checkbox" id="'.$option.'" value="'.$option.'" name="guest[]" '.$checked.'>';
                                    echo '<label for="'.$option.'">'.$option.'</label>';
                                } 
                                ?>
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
            				    <?php 
            				    if(isset($load_val['file_name'])){
        				           echo '<span id="file_name" style="margin-left : 8mm">'.$load_val['file_name'].'</span>';
            					   echo '<input type="button" id="file_delete" value="삭제">';
            				    }
            					?>
            				</td>
        				</tr>
        		</table>

    			<div style="float: right;">
    					<input type="hidden" id="update_num" name="update_num" value="<?=$load_val['info_num']?>">
    					<button id="save" type="submit" >저장</button>
    					<button type="button" onclick="location.href='list.php'">취소</button>
				</div>
			</form>
    	</div>
    	
    	<script type="text/javascript">
		$(function(){
	
	    	/* 아이디의 value를 가져오는 함수 */	
    		function GetVal(GV){
    			return document.getElementById(GV).value;
			}
		
/* 유효성 검사 */
			$('#save').click(function(){
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
          		$('#file_display').change(function(){
	            	var fileDisplay = $(this).val().replace("C:\\fakepath\\","");
    	        	$('#file_output').val(fileDisplay);
              	});
		
				/* 첨부파일 삭제 ajax */
              	$('#file_delete').click(function(){
          			var file_name = document.getElementById('file_name').innerHTML;
          			var info_num = document.getElementById('update_num').value;
          			alert(info_num);
          			
          			if(confirm("\"확인\" 버튼을 누르면 삭제가 진행됩니다.")){
              			$.ajax({
              					url : "./process/up_file_delete.php",
              					type : "POST",
              					data : {file_name : file_name,
              							info_num : info_num},
                                success: function(result) {
                                    alert(result);
                                    $('#file_name').hide();
                                    $('#file_delete').hide();
                                },
                                error : function(result){
                                	alert("실패");
                                }
              			});
              		}
              	});
   	 		});
    	</script>
	</body>
</html>