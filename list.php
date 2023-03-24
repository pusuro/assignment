<?php
/* con_query 함수, connect($con)가 있어서 쿼리문만 입력하면 됨 */
require_once 'process/con_query_function.php';

$result = con_query('SELECT * FROM information order by info_num desc');

echo "<br><br>";
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

    /* 제목 으로 검색할때 빈값 확인하여 반환 */
    if(empty($_GET['search_title'])){
        $search_title = '';
    }elseif (!empty($_GET['search_title'])){
        $search_title = $_GET['search_title'];
        $search_title_query = con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_title','%') ORDER BY info_num DESC;");
    }

    /* 작성자 로 검색할때 빈값 확인하여 반환 */
    if(empty($_GET['search_name'])){
        $search_name = '';
    }elseif(!empty($_GET['search_name'])){
        $search_name = $_GET['search_name'];
        $search_name_query = con_query("SELECT * FROM information WHERE info_name LIKE CONCAT('%','$search_name','%') ORDER BY info_num DESC;");
    }

    /* 제목과 작성자 조건으로 검색했을때*/
    if(!empty($_GET['search_title']) && !empty($_GET['search_name']) && empty($_GET['search_date_fir']) && empty($_GET['search_date_sec'])){
        $search_title = $_GET['search_title'];
        $search_name = $_GET['search_name'];
        $search_dual_query = con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_title','%') and info_name LIKE CONCAT('%','$search_name','%') ORDER BY info_num DESC;");
    }

    /* 제목 작성자 작성일 조건으로 검색했을때 */
    if (!empty($_GET['search_title']) && !empty($_GET['search_name']) && !empty($_GET['search_date_fir']) && !empty($_GET['search_date_sec'])){
        $search_title = $_GET['search_title'];
        $search_name = $_GET['search_name'];
        $search_date_fir = $_GET['search_date_fir'];
        $search_date_sec = $_GET['search_date_sec'];
        $search_quad_query = con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_title','%') and info_name LIKE CONCAT('%','$search_name','%') and info_date >= '$search_date_fir' AND info_date <= '$search_date_sec' ORDER BY info_num DESC;");
    }

    /* 날짜 조건으로 검색 */
    if(empty($_GET['search_date_fir']) && empty($_GET['search_date_sec'])){
        $search_date_fir = '';
        $search_date_sec = '';
    }elseif(!empty($_GET['search_date_fir']) && !empty($_GET['search_date_sec'])){
        $search_date_fir = $_GET['search_date_fir'];
        $search_date_sec = $_GET['search_date_sec'];
        $search_date_query = con_query("SELECT * FROM information WHERE info_date >= '$search_date_fir' AND info_date <= '$search_date_sec' ORDER BY info_num DESC;");
    }
    
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
    $numCount = con_query('SELECT info_num as infonum FROM information');
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
    $check_list = con_query("select info_num from information");
    
    $aaaaa = mysqli_fetch_assoc($check_list);
    
    if(empty($aaaaa['info_num'])){
?>
        <tr>
        <td colspan="7" style="text-align: center; height: 1cm;">표시할 자료가 없습니다.</td>
        </tr>
<?php
    }
    /* 제목 , 작성자 , 작성일 에 값이 없는 경우 */
    if(empty($search_title) && empty($search_name) && empty($search_date_fir) && empty($search_date_sec)){
        while ($nomal_result = mysqli_fetch_assoc($result)){
            
            $border_val = array(
                'num' => htmlspecialchars($nomal_result['info_num']),
                'division' => htmlspecialchars($nomal_result['info_division']),
                'title' => htmlspecialchars($nomal_result['info_title']),
                'date' => htmlspecialchars($nomal_result['info_date']),  
                'name' => htmlspecialchars($nomal_result['info_name']),
                'view' => htmlspecialchars($nomal_result['info_view']),
                'division' => htmlspecialchars($nomal_result['info_division'])
                );
?>
			<tr>
				<td class="border_other"><?=$border_val['num'] ?></td>
				<td class="border_other"><?=$border_val['division'] ?></td>
				<td class="border_title"><a href="read.php?list_num=<?=$border_val['num']?>"><?=$border_val['title'] ?></a></td>
				<td class="border_other"><img src="img/yesFile.png"></td>
				<td class="border_other"><?=$border_val['date'] ?></td>
				<td class="border_other"><?=$border_val['name'] ?></td>
				<td class="border_other"><?=$border_val['view'] ?></td>
			</tr>
<?php
        }
    /* 제목에 값이 있고 작성자와 작성일에 값이 없는 경우 */
    }elseif (!empty($_GET['search_title']) && empty($_GET['search_name']) && empty($_GET['search_date_fir']) && empty($_GET['search_date_sec'])){
        while($search_title_result = mysqli_fetch_assoc($search_title_query)){
            
            $search_title_val = array(
                'search_title_num' => htmlspecialchars($search_title_result['info_num']),
                'search_title_division' => htmlspecialchars($search_title_result['info_division']),
                'search_title_title' => htmlspecialchars($search_title_result['info_title']),
                'search_title_date' => htmlspecialchars($search_title_result['info_date']),
                'search_title_name' => htmlspecialchars($search_title_result['info_name']),
                'search_title_view' => htmlspecialchars($search_title_result['info_view']),
            );
?>          
            <tr>
                <td class="border_other"><?=$search_title_val['search_title_num'] ?></td>
                <td class="border_other"><?=$search_title_val['search_title_division'] ?></td>
                <td class="border_title"><?=$search_title_val['search_title_title'] ?></td>
                <td class="border_other"><img src="img/yesFile.png"> </td>
                <td class="border_other"><?=$search_title_val['search_title_date'] ?></td>
                <td class="border_other"><?=$search_title_val['search_title_name'] ?></td>
                <td class="border_other"><?=$search_title_val['search_title_view'] ?></td>
            </tr>
<?php
        }
    /* 작성자에 값이 있고 제목과 작성일에 값이 없는 경우 */    
    }elseif (!empty($_GET['search_name']) && empty($_GET['search_title']) && empty($_GET['search_date_fir']) && empty($_GET['search_date_sec'])){
        while($search_name_result = mysqli_fetch_assoc($search_name_query)){
            
            $search_name_val = array(
                'search_name_num' => htmlspecialchars($search_name_result['info_num']),
                'search_name_division' => htmlspecialchars($search_name_result['info_division']),
                'search_name_title' => htmlspecialchars($search_name_result['info_title']),
                'search_name_date' => htmlspecialchars($search_name_result['info_date']),
                'search_name_name' => htmlspecialchars($search_name_result['info_name']),
                'search_name_view' => htmlspecialchars($search_name_result['info_view']),
            );
?>
            <tr>
                <td class="border_other"><?=$search_name_val['search_name_num'] ?></td>
                <td class="border_other"><?=$search_name_val['search_name_division'] ?></td>
                <td class="border_title"><?=$search_name_val['search_name_title'] ?></td>
                <td class="border_other"><img src="img/yesFile.png"> </td>
                <td class="border_other"><?=$search_name_val['search_name_date'] ?></td>
                <td class="border_other"><?=$search_name_val['search_name_name'] ?></td>
                <td class="border_other"><?=$search_name_val['search_name_view'] ?></td>
            </tr>
<?php
        }
    /* 제목, 작성자 값이 있고 날짜 값이 없는 경우 */
    }elseif (!empty($_GET['search_title']) && !empty($_GET['search_name']) && empty($_GET['search_date_fir']) && empty($_GET['search_date_sec'])){
        while($search_dual_result = mysqli_fetch_assoc($search_dual_query)){
            
            $search_dual_val = array(
                'search_dual_num' => htmlspecialchars($search_dual_result['info_num']),
                'search_dual_division' => htmlspecialchars($search_dual_result['info_division']),
                'search_dual_title' => htmlspecialchars($search_dual_result['info_title']),
                'search_dual_date' => htmlspecialchars($search_dual_result['info_date']),
                'search_dual_name' => htmlspecialchars($search_dual_result['info_name']),
                'search_dual_view' => htmlspecialchars($search_dual_result['info_view']),
            );
?>
            <tr>
                <td class="border_other"><?=$search_dual_val['search_dual_num'] ?></td>
                <td class="border_other"><?=$search_dual_val['search_dual_division'] ?></td>
                <td class="border_title"><?=$search_dual_val['search_dual_title'] ?></td>
                <td class="border_other"><img src="img/yesFile.png"> </td>
                <td class="border_other"><?=$search_dual_val['search_dual_date'] ?></td>
                <td class="border_other"><?=$search_dual_val['search_dual_name'] ?></td>
                <td class="border_other"><?=$search_dual_val['search_dual_view'] ?></td>
            </tr>
<?php
        }
    /* 작성일 값이 있고 제목 작성자 값이 없는 경우 */
    }elseif (!empty($_GET['search_date_fir']) && !empty($_GET['search_date_sec']) && empty($_GET['search_title']) && empty($_GET['search_name'])){
        while($search_date_result = mysqli_fetch_assoc($search_date_query)){
            
            $search_date_val = array(
                'search_date_num' => htmlspecialchars($search_date_result['info_num']),
                'search_date_division' => htmlspecialchars($search_date_result['info_division']),
                'search_date_title' => htmlspecialchars($search_date_result['info_title']),
                'search_date_date' => htmlspecialchars($search_date_result['info_date']),
                'search_date_name' => htmlspecialchars($search_date_result['info_name']),
                'search_date_view' => htmlspecialchars($search_date_result['info_view']),
            );
?>
			<tr>
                <td class="border_other"><?=$search_date_val['search_date_num'] ?></td>
                <td class="border_other"><?=$search_date_val['search_date_division'] ?></td>
                <td class="border_title"><?=$search_date_val['search_date_title'] ?></td>
                <td class="border_other"><img src="img/yesFile.png"> </td>
                <td class="border_other"><?=$search_date_val['search_date_date'] ?></td>
                <td class="border_other"><?=$search_date_val['search_date_name'] ?></td>
                <td class="border_other"><?=$search_date_val['search_date_view'] ?></td>
            </tr>
<?php
        }
    /* 제목 작성자 날짜에 값이 있는 경우 */
    }elseif (!empty($_GET['search_title']) && !empty($_GET['search_name']) && !empty($_GET['search_date_fir']) && !empty($_GET['search_date_sec'])){
        while($search_quad_result = mysqli_fetch_assoc($search_quad_query)){
            
            $search_quad_val = array(
                'search_quad_num' => htmlspecialchars($search_quad_result['info_num']),
                'search_quad_division' => htmlspecialchars($search_quad_result['info_division']),
                'search_quad_title' => htmlspecialchars($search_quad_result['info_title']),
                'search_quad_date' => htmlspecialchars($search_quad_result['info_date']),
                'search_quad_name' => htmlspecialchars($search_quad_result['info_name']),
                'search_quad_view' => htmlspecialchars($search_quad_result['info_view']),
            );
?>
			<tr>
                <td class="border_other"><?=$search_quad_val['search_quad_num'] ?></td>
                <td class="border_other"><?=$search_quad_val['search_quad_division'] ?></td>
                <td class="border_title"><?=$search_quad_val['search_quad_title'] ?></td>
                <td class="border_other"><img src="img/yesFile.png"> </td>
                <td class="border_other"><?=$search_quad_val['search_quad_date'] ?></td>
                <td class="border_other"><?=$search_quad_val['search_quad_name'] ?></td>
                <td class="border_other"><?=$search_quad_val['search_quad_view'] ?></td>
            </tr>
<?php 
        }
    }
?>
		</table>
<?php 
    /* 페이징 작업 */
    $paging_query_result = con_query('select * from information');
    
    echo mysqli_num_rows($paging_query_result);
    
    /* 한 페이지에 10개씩 출력하면 페이지가 얼마나 나오는지 */
    $page_num = ceil(mysqli_num_rows($paging_query_result) / 10);
    echo '<br>';
    echo $page_num;
?>
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
				    for ($i = 1; $i < $page_num+1; $i++) {
				        echo '<span>';
    				        echo '<a href="#">';
    	   			          echo '<input type="button" value="'.$i.'">';
	   		  	            echo "<a>";
				        echo '</span>';
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