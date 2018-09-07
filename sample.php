<?php  


	include('includes/config.php');

	$query = mysqli_query($con, "SELECT medId from medicine");

	$data = array();

	while($row = mysqli_fetch_array($query)){
		array_push($data, $row['medId']);
	}

	shuffle($data);

	$length = sizeof($data);

	for($i=0; $i<($length-10); $i++){
		$medId = $data[$i];
		$qty = mt_rand(0,30);
		$queryInsert = mysqli_query($con, "INSERT into inventory values('', '$medId', 8, '$qty')");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Sample</title>
</head>
<body>

</body>
</html>