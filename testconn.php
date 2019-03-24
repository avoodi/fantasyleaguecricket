<html>
  <head>
    <title>testconn</title>
  </head>
  <body>
<?php

	function execute_query($conn, $query){
		$result = mysqli_query($conn, $query);
		if(!$result){
			die('<br>Invalid query: '.$query."<br>");
		} else {
			echo "<br>query '( $query )'  successfully executed<br>";
		}
		return $result;
	}

	function result_has_rows($result){
		if($result->num_rows){
			echo "<br>record already exists <br>";
			return true;
		}else{
			return false;
		}
	}

	function record_exists($column, $value, $conn, $table_name){
		$select_query = "select pid from $table_name where $column=$value;";
		$result = execute_query($conn, $select_query);
		return result_has_rows($result);
	}

?>
</body>
</html>
