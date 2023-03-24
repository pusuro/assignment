<?php

    print_r( $_FILES[ 'myfile' ] );
    echo "<br>";
    echo $_FILES[ 'myfile' ][ 'name' ];
    echo "<br>";
    echo $_FILES[ 'myfile' ][ 'type' ];
    echo "<br>";
    echo $_FILES[ 'myfile' ][ 'size' ];
    echo "<br>";
    echo $_FILES[ 'myfile' ][ 'tmp_name' ];
    echo "<br>";
    echo $_FILES[ 'myfile' ][ 'error' ];

?>
<html>
	<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
<div>
    <form action="" method="POST" enctype="multipart/form-data">
      <p><input type="file" name="myfile"></p>
      <p><input type="submit" name="action" value="Upload"></p>
    </form>
    
<?php
    $dir = 'upload_file/';
    
    if($_FILES['myfile']['error'] == 0){
        $tmp_name = $_FILES['myfile']['tmp_name'];
        $name = $_FILES['myfile']['name'];
        move_uploaded_file($tmp_name, $dir.$name);
    }
?>    
</div>
</html>

