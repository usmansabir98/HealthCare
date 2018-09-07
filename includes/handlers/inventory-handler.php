<?php  

if (isset($_POST['submitSupplierItem'])) {
		$brandName = $_POST['brandNameSupplier'];
		$manufacturer = $_POST['manufacturerSupplier'];
		$dosageForm = $_POST['dosageFormSupplier'];
		$pack = $_POST['packSupplier'];

		$numDrugs = $_POST['numDrugsSupplier'];
		$quantity = $_POST['itemQuantity'];
		$drugNames = array();
		$strengths = array();

		// echo $retailerLoggedIn;

		for ($i=0; $i < $numDrugs; $i++) { 
			$drugNames[$i] = $_POST['drugNameSupplier'.($i+1)];
			// echo $drugNames[$i]; 

			$strengths[$i] = $_POST['strengthSupplier'.($i+1)];
			// echo $strengths[$i];

		}

		$wasSuccessful = $inventory->register($brandName, $drugNames, $strengths, $manufacturer, $dosageForm, $pack, $quantity, $retailerLoggedIn);

		echo $inventory->getError(Constants::$invalidMedicine);

		if($wasSuccessful == true) {
			// header("Location: addInventory.php");


			echo "<div id='myModalSuccess' class='modal success-modal'>

            <div class='modal-content'>
              <div class='modal-header bg-success'>
                <h2>Succesful!</h2>

                <span class='close-modal'>&times;</span>
              </div>
              <div class='modal-body p-t-40 p-b-40'>
                <p style='text-align: center;'>Inventory successfully updated</p>
              
              </div>
            </div>

          </div>";


    echo "<script>
      setTimeout(function(){
        document.getElementById('myModalSuccess').style.display = 'block';
      }, 800);
      setTimeout(function(){
        document.getElementById('myModalSuccess').style.display = 'none';
      }, 2200);
    </script>";



		}
		else{
			echo "Could not be inserted";
		}
	}

?>