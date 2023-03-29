<?php 
    /* header('Location: list.php'); */    

    require_once 'process/con_query_function.php';
    
    $search_title = $_GET['search_title'] ?? '';
    $search_name = $_GET['search_name'] ?? '';
    $fir_date = $_GET['search_date_fir'] ?? '';
    $sec_date = $_GET['search_date_sec'] ?? '';

    $order_by = 'ORDER BY info_num DESC';

    $nomal_query = empty($search_title) && empty($search_name) && empty($fir_date) && empty($sec_date) ? con_query("select * from information") : '' ;
    $search_title_query = empty($search_title) ? '' : con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_title','%') $order_by");
    $search_name_query = empty($search_name) ? '' : con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_name','%') $order_by");
    $search_date_query = empty($fir_date) && empty($sec_date) ? '' : con_query("SELECT * FROM information WHERE info_date >= '$fir_date' AND info_date <= '$sec_date' $order_by;");
    $search_dual_query = empty($search_title) && empty($search_name) ? '' : con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_title','%') and info_name LIKE CONCAT('%','$search_name','%') $order_by;");
    $search_quad_query = empty($search_title) && empty($search_name) && empty($fir_date) && empty($sec_date) ? '' : con_query("SELECT * FROM information WHERE info_title LIKE CONCAT('%','$search_title','%') and info_name LIKE CONCAT('%','$search_name','%') and info_date >= '$fir_date' AND info_date <= '$sec_date' $order_by;");
    
?>
	<table border="1">
		<tr>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
		</tr>
<?php

    $search_query_select = '';
    if(!empty($nomal_query)){
        $search_query_select = $nomal_query;
    }elseif (!empty($search_title_query)){
        $search_query_select = $search_title_query;
    }
    while($row = mysqli_fetch_row($search_query_select)){
            
            echo "<tr>";
            echo "<td>$row[0]</td>";
            echo "<td>$row[1]</td>";
            echo "<td>$row[2]</td>";
            echo "<td>$row[3]</td>";
            echo "</tr>";
    }
?>
    </table>
<html>

		<form action="" method="get">
        	<div id="LS">
        		<span>제목</span> <input type="text" name="search_title">
        		<span>작성자</span> <input type="text" name="search_name">
        		<span>작성일</span> <input id="firDate" type="date" name="search_date_fir">
        		<span>~</span> <input id="secDate" type="date" name="search_date_sec">
        		<button type="submit">검색</button>
        	</div>
        </form>


<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
	<body>
		<h1>실행</h1>

	</body>
	
		<form action="think.php" method="post">
			<input type="file">
			<input type="submit">
		</form>

<script type="text/javascript">
$(function(){
	/* alert("로딩완료") */



});



</script>


</html>