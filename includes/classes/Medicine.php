<?php
	class Medicine {

		private $con;
		private $errorArray;

		public function __construct($con) {
			$this->con = $con;
			$this->errorArray = array();
		}

		public function register($brandName, &$drugNames, &$strengths, $manufacturer, $dosageForm, $pack) {

			$this->validateRecord($brandName, $drugNames, $strengths, $manufacturer, $dosageForm, $pack);

			if(empty($this->errorArray) == true) {
				//Insert into db

				return $this->insertMedicineDetails($brandName, $drugNames, $strengths, $manufacturer, $dosageForm, $pack);
			}
			else {
				return false;
			}

		}

		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
				echo $error;
			}
			else{
				echo "<div id='myModalFailure' class='modal success-modal'>

            <div class='modal-content'>
              <div class='modal-header bg-danger'>
                <h2 style='color: white;'>Failed!</h2>

                <span class='close-modal'>&times;</span>
              </div>
              <div class='modal-body p-t-40 p-b-40'>
                <p style='text-align: center;'>$error</p>
              
              </div>
            </div>

          </div>";


    echo "<script>
      setTimeout(function(){
        document.getElementById('myModalFailure').style.display = 'block';
      }, 800);
      setTimeout(function(){
        document.getElementById('myModalFailure').style.display = 'none';
      }, 2500);
    </script>";
			}
		}

		private function validateRecord($brandName, &$drugNames, &$strengths, $manufacturer, $dosageForm, $pack){

			// Getting brandId
			$brand = mysqli_query($this->con, "SELECT brandId FROM brandname WHERE brandName='$brandName'");

			if(mysqli_num_rows($brand)==0){
				return;
			}
			$row = mysqli_fetch_array($brand);
			$brandId = $row['brandId'];

			// Getting manId
			$man = mysqli_query($this->con, "SELECT manId FROM manufacturer WHERE manName='$manufacturer'");

			if(mysqli_num_rows($man)==0){
				return;
			}
			$row = mysqli_fetch_array($man);
			$manId = $row['manId'];

			// Getting formId
			$form = mysqli_query($this->con, "SELECT formId FROM dosageform WHERE formName='$dosageForm'");

			if(mysqli_num_rows($form)==0){
				return;
			}
			$row = mysqli_fetch_array($form);
			$formId = $row['formId'];

			$result = mysqli_query($this->con, "SELECT medId FROM medicine WHERE brandId='$brandId' AND manId='$manId' AND formId='$formId' AND pack='$pack'");

			if(mysqli_num_rows($result)==0){
				return;
			}

			// creating arrays for drug lists
			$drugIdArray = array();
			$strengthsArray = array();

			while ($drugName = array_pop($drugNames)) {
				$strength = array_pop($strengths);

				$drug = mysqli_query($this->con, "SELECT drugId FROM genericname WHERE drugName='$drugName'");


				if(mysqli_num_rows($drug)==0){
					return;
				}

				$row = mysqli_fetch_array($drug);
				$drugId = $row['drugId'];

				array_push($drugIdArray, $drugId);
				array_push($strengthsArray, $strength);


			}

			while($row = mysqli_fetch_array($result)){

				$medId = $row['medId'];

				$medigeneric = mysqli_query($this->con, "SELECT * FROM medigeneric WHERE medId='$medId'");

				// if (mysqli_num_rows($result)!=sizeof($drugIdArray)) {
				// 	echo "Error from different sizes";
				// 	echo mysqli_num_rows($result);
				// 	echo sizeof($drugIdArray);
				// 	array_push($this->errorArray, Constants::$duplicateRecord);
				// 	return;
				// }

				$array = array();
				while ($drug = mysqli_fetch_array($medigeneric)) { 
					# code...
					$num = 0;
					$array[$num] = 0;
					for ($i=0; $i < sizeof($drugIdArray); $i++){
						// echo "loop runs";
						// echo $drug['drugId'];
						// echo $drugIdArray[$i];
						// echo $drug['strength'];
						// echo $strengthsArray[$i];

						if($drug['drugId']==$drugIdArray[$i] && $drug['strength']==$strengthsArray[$i]){
							$array[$num] = 1;
							break;		
						}
					}
					$num++;
				}

				if(!in_array(0, $array)){
					array_push($this->errorArray, Constants::$duplicateRecord);
					return;
				}

			}

		}

		private function insertMedicineDetails($brandName, &$drugNames, &$strengths, $manufacturer, $dosageForm, $pack) {

			$result = mysqli_query($this->con, "SELECT brandId FROM brandname WHERE brandName='$brandName'");

			if(mysqli_num_rows($result)==0){
				$result = mysqli_query($this->con, "INSERT INTO brandname VALUES('', '$brandName')");
			}

			$result = mysqli_query($this->con, "SELECT manId FROM manufacturer WHERE manName='$manufacturer'");

			if(mysqli_num_rows($result)==0){
				$result = mysqli_query($this->con, "INSERT INTO manufacturer VALUES('', '$manufacturer')");
			}

			$result = mysqli_query($this->con, "SELECT formId FROM dosageform WHERE formName='$dosageForm'");

			if(mysqli_num_rows($result)==0){
				$result = mysqli_query($this->con, "INSERT INTO dosageform VALUES('', '$dosageForm')");
			}

			// for medigeneric table
			$med = mysqli_query($this->con, "SELECT `AUTO_INCREMENT` AS lastId FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'healthcare' AND TABLE_NAME = 'medicine';");
			$row = mysqli_fetch_array($med);
			$medId = $row['lastId'];

			while ($drugName = array_pop($drugNames)) {
				$strength = array_pop($strengths);

				$result = mysqli_query($this->con, "SELECT drugId FROM genericname WHERE drugName='$drugName'");


				if(mysqli_num_rows($result)==0){
					$result = mysqli_query($this->con, "INSERT INTO genericname VALUES('', '$drugName')");
				}

				// inserting into medigeneric

				$drug = mysqli_query($this->con,"SELECT drugId FROM genericname WHERE drugName='$drugName'");
				$row = mysqli_fetch_array($drug);
				$drugId = $row['drugId'];

				$result = mysqli_query($this->con, "INSERT INTO medigeneric VALUES('$medId', '$drugId', '$strength')");

			}



			// inserting into medicine
			$brand = mysqli_query($this->con, "SELECT brandId FROM brandname WHERE brandName='$brandName'");
			$row = mysqli_fetch_array($brand);
			$brandId = $row['brandId'];

			$man = mysqli_query($this->con, "SELECT manId FROM manufacturer WHERE manName='$manufacturer'");
			$row = mysqli_fetch_array($man);
			$manId = $row['manId'];

			$form = mysqli_query($this->con, "SELECT formId FROM dosageform WHERE formName='$dosageForm'");
			$row = mysqli_fetch_array($form);
			$formId = $row['formId'];
			
			$result = mysqli_query($this->con, "INSERT INTO medicine VALUES('', '$brandId', '$manId', '$formId', '$pack')");

			return $result;
		}

	}
?>