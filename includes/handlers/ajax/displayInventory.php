<?php 
	include('../../config.php');

	if(isset($_GET['term'])){
		$term = urldecode($_GET['term']);
	}
	else{
		$term = "";
	}

	if($term!=""){
		$term = ucfirst($term);
		$query = mysqli_query($con, "SELECT inventory.itemId, medicine.medId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack, inventory.quantity FROM inventory 
INNER JOIN medicine ON inventory.medId = medicine.medId

INNER JOIN brandname ON medicine.brandId = brandname.brandId
INNER JOIN manufacturer ON medicine.manId = manufacturer.manId
INNER JOIN dosageform ON medicine.formId = dosageform.formId
WHERE inventory.supplierId = (SELECT id FROM retailer WHERE emailid = '$term')");
		
		$data = array();

		while($row = mysqli_fetch_array($query)){
			array_push($data, $row);
		}

		//Fetch the drugnames included in the specific medicines
		//Fetch the strengths of each drug included in the medicine
		for ($x = 0; $x < sizeof($data) ; $x++){
			$medId = $data[$x]['medId'];
			$query2 = mysqli_query($con, "SELECT genericname.drugName, medigeneric.strength FROM genericname
			INNER JOIN medigeneric ON genericname.drugId = medigeneric.drugId
			WHERE medigeneric.medId = '$medId'");

			$data[$x]['drugs'] = array();
			$data[$x]['strengths'] = array();
			while($row = mysqli_fetch_array($query2)){
				// array_push($data, $row);
				array_push($data[$x]['drugs'],$row['drugName']);
				array_push($data[$x]['strengths'],$row['strength']);
			}
		}
		
		// return $data;
		echo json_encode($data) ;
	}






// SELECT medigeneric.drugId, medigeneric.strength FROM medigeneric WHERE medigeneric.medId IN (1,2,3,6,7) ;


?>