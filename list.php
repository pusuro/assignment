<?php
/* con_query 함수, connect($con)가 있어서 쿼리문만 입력하면 됨 */
require_once 'process/con_query_function.php';

require_once 'process/paging.php';

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

    $select_from = 'SELECT * FROM information ';
    $order_by = 'ORDER BY info_num DESC';

    $nomal_query = '';
    $search_dual_query = '';
    
    if (!empty($search_title) && !empty($search_name) && !empty($fir_date) && !empty($sec_date)) {
        $search_quad_query = con_query("$select_from WHERE info_title LIKE CONCAT('%','$search_title','%') and info_name LIKE CONCAT('%','$search_name','%') and info_date >= '$fir_date' AND info_date <= '$sec_date' $order_by LIMIT $start , $count_per_page");
    } elseif (!empty($search_title) && !empty($search_name) && empty($fir_date) && empty($sec_date)) {
        $search_dual_query = con_query("$select_from WHERE info_title LIKE CONCAT('%','$search_title','%') and info_name LIKE CONCAT('%','$search_name','%') $order_by LIMIT $start , $count_per_page");
    } elseif (!empty($search_title)) {
        $search_title_query = con_query("$select_from WHERE info_title LIKE CONCAT('%','$search_title','%') $order_by LIMIT $start , $count_per_page");
    } elseif (!empty($search_name)) {
        $search_name_query = con_query("$select_from WHERE info_title LIKE CONCAT('%','$search_name','%') $order_by LIMIT $start , $count_per_page");
    } elseif (!empty($fir_date) && !empty($sec_date)) {
        $search_date_query = con_query("$select_from WHERE info_date >= '$fir_date' AND info_date <= '$sec_date' $order_by LIMIT $start , $count_per_page");
    } elseif (empty($search_title) && empty($search_name) && empty($fir_date) && empty($sec_date)) {
        $nomal_query = con_query("$select_from $order_by LIMIT $start , $count_per_page");
    }
    
    ?>
		<form action="" method="get">
        	<div id="LS">
        		<span>제목</span> <input type="text" id ="search_title" name="search_title" value="<?=$search_title?>">
        		<span>작성자</span> <input type="text" id="search_name" name="search_name" value="<?=$search_name?>">
        		<span>작성일</span> <input id="firDate" type="date" id="search_date_fir" name="search_date_fir" value="<?=$fir_date?>">
        		<span>~</span> <input id="secDate" type="date" id="search_date_sec" name="search_date_sec" value="<?=$sec_date?>">
        		<button type="submit">검색</button>
        	</div>
        </form>
<?php
    /* 글 갯수와 페이지 갯수 변수 , 게시글이 없는 경우(74라인) 쿼리 */
    $numCount = con_query('SELECT info_num FROM information');
    $numCount_val = mysqli_num_rows($numCount);
?>
    	<div id="check_page">
			<span>Total : <?= $numCount_val ?></span>
			<span>&nbsp Page : <?php echo $now_page."/".$total_page?></span>
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
    /* $check_list_query = con_query('SELECT info_num FROM information') */
    $check_list = mysqli_fetch_assoc($numCount);

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
    
    if ($search_query_select != $nomal_query && $search_query_select->num_rows == 0 ) {
        echo '<tr>';
        echo '<td colspan="7" style="text-align: center; height: 1cm;">검색 결과가 없습니다.</td>';
        echo '</tr>';
    }
    
    /* $result_query = con_query("SELECT * FROM information ORDER BY info_num DESC LIMIT $start, $count_per_page"); */
    
    while ($border_list = mysqli_fetch_array($search_query_select)) {

        echo '<tr>';
        echo '<td class="border_other">'.$border_list[0].'</td>';
        echo '<td class="border_other">'.$border_list[2].'</td>';
        echo '<td class="border_title"><a href="read.php?list_num='.$border_list['0'].'">'.$border_list[5].'</a></td>';
        
        $file_check = con_query("select file_name from file_manager where num='".$border_list['info_num']."'");
        if(mysqli_fetch_assoc($file_check) != NULL){
            echo '<td class="border_other"><img src="img/yesFile.png"></td>';
        }else
            echo '<td class="border_other"></td>';
            echo '<td class="border_other">'.$border_list[7].'</td>';
            echo '<td class="border_other">'.$border_list[1].'</td>';
            echo '<td class="border_other">'.$border_list[8].'</td>';
        echo '</tr>';
    }
?>
		</table>
		<div id="move_page">
			<span>
				<a href="#"> << </a>
			</span>
			<span>
				<a href="#"> < </a>
			</span>
				<?php
				
				$now_page = isset($_GET['list_page']) ? $_GET['list_page'] : 1; // 기본값 1
				$count_per_page = 10;
				
				$total_count_query = con_query("SELECT COUNT(*) FROM information");
				$total_count_array = mysqli_fetch_array($total_count_query);
				$total_count = $total_count_array[0];
				
				$total_page = ceil($total_count / $count_per_page);
				
				$start = ($now_page - 1) * $count_per_page; // 페이지의 시작 인덱스

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
				
				$search_title_query = '';
				if($search_query_select == $search_title_query){
				    $total_count_query = $search_query_select->num_rows;
				    echo $total_count_query;
				    var_dump($total_count_query);
				}
				
				
				
    				for ($i = 1; $i <= $total_page; $i++) {
    				    echo '<span>';
    				    echo '<a href=\'list.php?list_page='.$i.'&?search_title='.$search_title.'&?search_name='.$search_name.'&?search_date_fir='.$fir_date.'&?search_date_sec='.$sec_date.'\'" id="page'.$i.'">'.$i.'</a>';
    				    echo '</span>';
				}
                ?>
			<span>
				<a href="#"> > </a>
			</span>
			<span>
				<a href="#"> >> </a>
			</span>
			<div style="float: right;">
				<button type="button" onclick="location.href='insert.php'">등록</button>
			</div>
		</div>
		
	</body>
</html>