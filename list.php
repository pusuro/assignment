<?php
/* con_query 함수, connect($con)가 있어서 쿼리문만 입력하면 됨 */
require_once 'process/con_query_function.php';

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
    
    while($row = mysqli_fetch_array($search_query_select)){
    
        echo '<tr>';
        echo '<td class="border_other">'.$row[0].'</td>';
        echo '<td class="border_other">'.$row[2].'</td>';
        echo '<td class="border_title"><a href="read.php?list_num='.$row['0'].'">'.$row[5].'</a></td>';

        /* 해당 게시글에 파일이 있는 경우 이미지 생성 */
        $file_check = con_query("select file_name from file_manager where num='".$row['info_num']."'");
        
        if(mysqli_fetch_assoc($file_check) != NULL){
            echo '<td class="border_other"><img src="img/yesFile.png"></td>';
        }else
            echo '<td class="border_other"></td>';
        echo '<td class="border_other">'.$row[7].'</td>';
        echo '<td class="border_other">'.$row[1].'</td>';
        echo '<td class="border_other">'.$row[8].'</td>';
        echo '</tr>';
    }
	
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
				<?php
				
				/* 페이징 작업 */
				$page = isset($_GET['page']) ? $_GET['page'] : 1; // 기본값 1
				$count_per_page = 10;
				
				/* 게시글 갯수 */
				$total_count_query = con_query("SELECT COUNT(*) FROM information");
				$total_count_array = mysqli_fetch_array($total_count_query);
				$total_count = $total_count_array[0];
				
				$total_page = ceil($total_count / $count_per_page);
				
				$start = ($page - 1) * $count_per_page; // 페이지의 시작 인덱스
				$result_query = con_query("SELECT * FROM information ORDER BY info_num DESC LIMIT $start, $count_per_page");
				
				for ($i = 1; $i <= $total_page; $i++) {
				        echo '<span>';
				        echo '<input type="submit" id="page'.$i.'" value="'.$i.'" onclick="location.href=\'list.php?page='.$i.'\'">';
				        echo '</span>';
				    }
				    
				    while ($roww = mysqli_fetch_array($result_query)) {
				        $id = $roww[0];
				        $title = $roww[2];
				        $content = $roww[1];
				        $author = $roww[3];
				        $created_at = $roww[4];
				        echo "<table>";
			            echo "<tr>";
				        echo "<td>$id</td>";
				        echo "<td>$title</td>";
				        echo "<td>$content</td>";
			            echo "</tr>";
				        echo "</table>";
				    }
				    
                ?>
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