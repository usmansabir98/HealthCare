<?php
	class Inventory {

		private $con;
		private $errorArray;

		public function __construct($con) {
			$this->con = $con;
			$this->errorArray = array();
		}

		public function register($brandName, &$drugNames, &$strengths, $manufacturer, $dosageForm, $pack, $quantity, $supplier) {

			$medId = $this->validateRecord($brandName, $drugNames, $strengths, $manufacturer, $dosageForm, $pack);

			if(empty($this->errorArray) == true) {
				//Insert into db

				return $this->insertMedicineDetails($medId, $quantity, ucfirst($supplier));
			}
			else {
				return false;
			}

		}

		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		private function validateRecord($brandName, &$drugNames, &$strengths, $manufacturer, $dosageForm, $pack){

			$query = mysqli_query($this->con, "SELECT medId FROM medicine
WHERE brandId = (SELECT brandId FROM brandname WHERE brandname='$brandName')
AND manId = (SELECT manId FROM manufacturer WHERE manName='$manufacturer')
AND formId = (SELECT formId FROM dosageform WHERE formName='$dosageForm')
AND pack = '$pack';");

			if(mysqli_num_rows($query)==0){
				array_push($this->errorArray, Constants::$invalidMedicine);
					return;
			}

			// creating arrays for drug lists
			$drugIdArray = array();
			$strengthsArray = array();

			while ($drugName = array_pop($drugNames)) {
				$strength = array_pop($strengths);

				$drug = mysqli_query($this->con, "SELECT drugId FROM genericname WHERE drugName='$drugName'");


				$row = mysqli_fetch_array($drug);
				$drugId = $row['drugId'];

				array_push($drugIdArray, $drugId);
				array_push($strengthsArray, $strength);


			}

			while($row = mysqli_fetch_array($query)){

				$medId = $row['medId'];

				$medigeneric = mysqli_query($this->con, "SELECT * FROM medigeneric WHERE medId='$medId'");

				$array = array();
				while ($drug = mysqli_fetch_array($medigeneric)) { 
					# code...
					$num = 0;
					$array[$num] = 0;
					for ($i=0; $i < sizeof($drugIdArray); $i++){
						

						if($drug['drugId']==$drugIdArray[$i] && $drug['strength']==$strengthsArray[$i]){
							$array[$num] = 1;
							break;		
						}
					}
					$num++;
				}

				if(!in_array(0, $array)){
					// array_push($this->errorArray, Constants::$duplicateRecord);
					return $medId;
				}

			}

		}

		private function insertMedicineDetails($medId, $quantity, $supplier) {

			$supplierId = mysqli_query($this->con, "SELECT id from retailer WHERE emailid='$supplier'");

			$row = mysqli_fetch_array($supplierId);
			$supplierId = $row['id'];

			$result = mysqli_query($this->con, "INSERT INTO Inventory VALUES('', '$medId', '$supplierId', '$quantity')");

			return $result;
		}

	}
?>