<?php 
	include('../../config.php');

	if(isset($_GET['term'])){
		$term = urldecode($_GET['term']);
	}
	else{
		$term = "";
	}

	if($term!=""){

		$query = mysqli_query($con, "SELECT DISTINCT brandname.brandName, manufacturer.manName FROM medicine
		INNER JOIN brandname ON medicine.brandId = brandname.brandId
		INNER JOIN manufacturer ON medicine.manId = manufacturer.manId
		WHERE medicine.medId IN (SELECT medigeneric.medId FROM medigeneric
		WHERE medigeneric.drugId = (SELECT drugId FROM genericname WHERE drugName = '$term'))");


		$data = array();

		while($row = mysqli_fetch_array($query)){
			array_push($data, $row);
		}

		
		// return $data;
		echo json_encode($data) ;
	}

?>