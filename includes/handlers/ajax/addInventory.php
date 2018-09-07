<?php 

	include('../../config.php');

	if(isset($_GET['term'])){
		$term = urldecode($_GET['term']);
	}
	else{
		$term = "";
	}

	if($term!=""){
		$query = mysqli_query($con, "SELECT medicine.medId, brandname.brandName, manufacturer.manName, dosageform.formName, pack FROM medicine 
INNER JOIN brandname ON medicine.brandId = brandname.brandId
INNER JOIN manufacturer ON medicine.manId = manufacturer.manId
INNER JOIN dosageform ON medicine.formId = dosageform.formId
WHERE medicine.brandId = (SELECT brandId FROM brandname WHERE brandName='$term');");

		$data = array();

		while($row = mysqli_fetch_array($query)){
			array_push($data, $row);	
		}

		echo json_encode($data);

	}

	$medIdsArray = array();
	if(isset($_GET['medIds'])){
		$medIdString = $_GET['medIds'];

		$medIdsArray = explode(",", $medIdString);
		// $medIds = json_decode($_GET['medIds']);
	}
	else{
		$medIdsArray = [];
	}

	if($medIdsArray){

			$query = mysqli_query($con, "SELECT medigeneric.medId, medigeneric.drugId, genericname.drugName, medigeneric.strength
	FROM medigeneric
	INNER JOIN genericname ON medigeneric.drugId = genericname.drugId
	WHERE medigeneric.medId IN (".$medIdString.")");

			$data = array();

		while($row = mysqli_fetch_array($query)){
			array_push($data, $row);	
		}

		echo json_encode($data);
	}



	/*
	SELECT medicine.medId, brandname.brandName, manufacturer.manName, dosageform.formName, medigeneric.drugId, genericname.drugName, medigeneric.strength, pack FROM medicine 
	INNER JOIN brandname ON medicine.brandId = brandname.brandId
	INNER JOIN manufacturer ON medicine.manId = manufacturer.manId
	INNER JOIN dosageform ON medicine.formId = dosageform.formId
	INNER JOIN medigeneric ON medicine.medId = medigeneric.medId
	INNER JOIN genericname ON medigeneric.drugId = genericname.drugId
	WHERE medicine.brandId = (SELECT brandId FROM brandname WHERE brandName='FUROSINOL');
	*/


?>

