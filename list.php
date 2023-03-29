<?php
/* con_query 함수, connect($con)가 있어서 쿼리문만 입력하면 됨 */
require_once 'process/con_query_function.php';

/* $result = con_query('SELECT * FROM information ORDER BY info_num desc LIMIT 10'); */

?>

<html>
	<head>
		<link href="css/list.css?after" rel="stylesheet">
		<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
	</head>

	<body style="width: 1300px; margin: auto; margin-top: 3cm;">

    	<h1 onclick="location.href = 'list.php';">목록</h1>
    	<hr>

<?php

    $search_title = $_GET['search_title'] ?? '';
    $search_name = $_GET['search_name'] ?? '';
    $fir_date = $_GET['search_date_fir'] ?? '';
    $sec_date = $_GET['search_date_sec'] ?? '';

    $order_by = 'ORDER BY info_num DESC';

    $nomal_query = empty($search_title) && empty($search_name) && empty($fir_date) && empty($sec_date) ? con_query("select * from information $order_by LIMIT 10") : '' ;

    $search_title_query = empty($search_title) ? '' : con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_title','%') $order_by");
    
    $search_name_query = empty($search_name) ? '' : con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_name','%') $order_by");
    
    $search_date_query = empty($fir_date) && empty($sec_date) ? '' : con_query("SELECT * FROM information WHERE info_date >= '$fir_date' AND info_date <= '$sec_date' $order_by;");
    
    $search_dual_query = empty($search_title) && empty($search_name) ? '' : con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_title','%') and info_name LIKE CONCAT('%','$search_name','%') $order_by;");
    
    $search_quad_query = empty($search_title) && empty($search_name) && empty($fir_date) && empty($sec_date) ? '' : con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_title','%') and info_name LIKE CONCAT('%','$search_name','%') and info_date >= '$fir_date' AND info_date <= '$sec_date' $order_by;");
    
    ?>
		<form action="" method="get">
        	<div id="LS">
        		<span>제목</span> <input type="text" name="search_title">
        		<span>작성자</span> <input type="text" name="search_name">
        		<span>작성일</span> <input id="firDate" type="date" name="search_date_fir">
        		<span>~</span> <input id="secDate" type="date" name="search_date_sec">
        		<button type="submit">검색</button>
        	</div>
        </form>
<?php

    /* 글 갯수와 페이지 갯수 변수 */
    $numCount = con_query('SELECT info_num FROM information');
    $numCount_val = mysqli_num_rows($numCount);
?>
    	<div id="check_page">
			<span>Total : <?= $numCount_val ?></span>
			<span>&nbsp Page : 1/2</span>
		</div>
		<table id="LP">
			<tr>
				<th>번호</th>
				<th>구분</th>
				<th>제목</th>
				<th>첨부</th>
				<th>작성일</th>
				<th>작성자</th>
				<th>조회수</th>
			</tr>
<?php
    /* 게시글이 없는 경우 */
    $check_list_query = con_query("select info_num from information");
    
    $check_list = mysqli_fetch_assoc($check_list_query);
    
    if(empty($check_list['info_num'])){
       echo '<tr>';
       echo '<td colspan="7" style="text-align: center; height: 1cm;">표시할 게시글이 없습니다.</td>';
       echo '</tr>';
    }
    
    function img_check($get_img) {
        
        
        ;
    }
    
    /* 빈값을 확인하여 검색 쿼리 적용 */
    $search_query_select = '';
    if(!empty($nomal_query)){
        $search_query_select = $nomal_query;
    }elseif (!empty($search_title_query)){
        $search_query_select = $search_title_query;
    }elseif(!empty($search_name_query)){
        $search_query_select = $search_name_query;
    }elseif (!empty($search_date_query)){
        $search_query_select = $search_date_query;
    }elseif ($search_dual_query){
        $search_query_select = $search_dual_query;
    }elseif ($search_quad_query){
        $search_query_select = $search_quad_query;
    }
    while($row = mysqli_fetch_row($search_query_select)){
    
        echo '<tr>';
        echo '<td class="border_other">'.$row[0].'</td>';
        echo '<td class="border_other">'.$row[2].'</td>';
        echo '<td class="border_title">'.$row[5].'</td>';
        echo '<td class="border_other"><img src="img/yesFile.png"></td>';
        echo '<td class="border_other">'.$row[7].'</td>';
        echo '<td class="border_other">'.$row[1].'</td>';
        echo '<td class="border_other">'.$row[8].'</td>';
        echo '</tr>';
    }
    
    /* 페이징 작업 */
    $paging_query_result = con_query('select * from information');
    
    echo mysqli_num_rows($paging_query_result);
    
    /* 한 페이지에 10개씩 출력하면 페이지가 얼마나 나오는지 */
    $page_num = ceil(mysqli_num_rows($paging_query_result) / 10);
    echo '<br>';
    echo $page_num;
?>
		</table>
		<div id="move_page">
			<span>
				<a href="#">
					<input type="button" value=" << " style="width: 15mm;">
				</a>
			</span>
			<span>
				<a href="#">
					<input type="button" value=" < ">
				</a>
			</span>
			<form action="" method="GET" style="display: inline-block;">
				<?php
				if(mysqli_num_rows($paging_query_result) == 0){
				    $page_num = 1;
				}
				    for ($i = 1; $i <= $page_num; $i++) {
				        echo '<span>';
    				        echo '<input type="submit" id="'.'page'.$i.'" value="'.$i.'">';
				        echo '</span>';
				    }
				?>
			</form>
			<span>
				<a href="#">
					<input type="button" value=" > ">
				</a>
			</span>
			<span>
				<a href="#">
					<input type="button" value=" >> " style="width: 15mm;">
				</a>
			</span>
			<div style="float: right;">
				<button type="button" onclick="location.href='insert.php'">등록</button>
			</div>
		</div>
	</body>
</html>