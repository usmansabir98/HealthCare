<?php 

	function sanitizeName($inputText){
		$inputText = strtoupper($inputText);
		$inputText = trim($inputText);
		
		return $inputText;
	}

	function sanitizeUnit($inputText){
		$inputText = strtolower($inputText);
		$inputText = trim($inputText);
		$inputText = str_replace(" ", "", $inputText);
		
		return $inputText;
	}

	function sanitizeDrug($inputText){
		$inputText = strtolower($inputText);
		$inputText = ucwords($inputText);
		$inputText = trim($inputText);
		
		return $inputText;
	}

	if (isset($_POST['medicineEntry'])) {
		$brandName = sanitizeName($_POST['brandName']);
		$manufacturer = sanitizeName($_POST['manufacturer']);
		$dosageForm = sanitizeDrug($_POST['dosageForm']);
		$pack = sanitizeUnit($_POST['pack']);

		$numDrugs = $_POST['numDrugs'];
		$drugNames = array();
		$strengths = array();

		for ($i=0; $i < $numDrugs; $i++) { 
			$drugNames[$i] = sanitizeDrug($_POST['drugName'.($i+1)]);

			$strengths[$i] = sanitizeUnit($_POST['strength'.($i+1)]);
		}
		

		$wasSuccessful = $medicine->register($brandName, $drugNames, $strengths, $manufacturer, $dosageForm, $pack);

		if($wasSuccessful == true) {
			// header("Location: index.php");

			echo "<div id='myModalSuccess' class='modal success-modal'>

            <div class='modal-content'>
              <div class='modal-header bg-success'>
                <h2>Succesful!</h2>

                <span class='close-modal'>&times;</span>
              </div>
              <div class='modal-body p-t-40 p-b-40'>
                <p style='text-align: center;'>Medicine added!</p>
              
              </div>
            </div>

          </div>";


    echo "<script>
      setTimeout(function(){
        document.getElementById('myModalSuccess').style.display = 'block';
      }, 800);
      setTimeout(function(){
        document.getElementById('myModalSuccess').style.display = 'none';
      }, 2500);
    </script>";
		}
	}
?>