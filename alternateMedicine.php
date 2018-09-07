

<?php

//localhost/HealthCare/alternateMedicine.php?term=49
// include('includes/config.php');
  if(isset($_GET['term'])){
		$medId = urldecode($_GET['term']);
	}



if($medId!=""){

	  $Dquery = mysqli_query($con, "SELECT drugId,strength from medigeneric where medId='$medId'");
    $Bquery = mysqli_query($con, "SELECT brandId from medicine where medId='$medId'");
    $brow = mysqli_fetch_array($Bquery);
    $brandid = $brow['brandId'];
	
		
		//$data = array();
		$strengthArray= array();
		$drugArray =array();
		$strengthString='';
		$drugString="(";  // creating a string to store drug

		while($row = mysqli_fetch_array($Dquery)){
			//array_push($data, $row);
			array_push($drugArray, $row['drugId']);
			array_push($strengthArray, $row['strength']);
		}

		/////////////////////////////////////concerting into a string
        $i = sizeof($drugArray);
        $DrugArraysize = sizeof($drugArray);
        $i = $i - 1;  //count of commas 1 less than no of drugIds
		foreach ($drugArray as $drug) {

			$drugString = $drugString  . $drug ;
			
			if($i>0){
				$drugString = $drugString  . ',' ; 
			}
			$i = $i - 1;

		}

		$drugString = $drugString . ')';
		//for string

		 //count of commas 1 less than no of drugIds
		// foreach ($strengthArray as $s) {

		// 	$strengthString  = $strengthString  . $s ;
	
		// }



		///
        ////////////////////////////
        //fetching alternate medid with drugs
	   $Mquery = mysqli_query($con, "SELECT medigeneric.medId, count(medigeneric.medId) FROM medigeneric
          	INNER JOIN medicine ON medicine.medId = medigeneric.medId
	    WHERE drugId in $drugString AND medicine.brandId NOT IN($brandid) group BY medigeneric.medId having count(medigeneric.medId)=$DrugArraysize;");
	   $dataAlt = array();

	   $AlternateStrengthArray= array();
	   $AlternateStrengthString='';
	   $AlternateMedId= array();
	   $AlternateDrugArray=array();

        while($mrow = mysqli_fetch_array($Mquery)){

      	

      	array_push($AlternateMedId, $mrow['medId']);		
      	array_push($dataAlt, $mrow);
		}
        ///////
        //now geting their strengths and drugId in and order(of each alternate medid found) to compare
        ////
		$alternate = array();
		foreach ($AlternateMedId as $medid) {
			$medId=$medid;
        $strengthquery = mysqli_query($con, "SELECT drugId, strength from medigeneric where medId=$medId");

        while($Srow = mysqli_fetch_array($strengthquery)){
            
        	array_push($AlternateStrengthArray, $Srow['strength']);
        	array_push($AlternateDrugArray, $Srow['drugId']);
        } //end of while
         $flag=0;
        for ($x = 0; $x < sizeof($drugArray) ; $x++){
            if(in_array($drugArray[$x],$AlternateDrugArray)){  
            	$key = array_search($drugArray[$x], $AlternateDrugArray); // $key = 2;                
							if($AlternateStrengthArray[$key]==$strengthArray[$x])
                  $flag=1;
            }
            else{
              $flag=0;
              break;
            }

        } //end of for loop

	       if($flag==1 && (sizeof($AlternateDrugArray)===sizeof($drugArray))){
	       	// echo "correct";
	       	array_push($alternate, $medId);
	       }
	       else{
	       	// echo "wrong";
	       }

           //making this alternate arrays empty
        unset($AlternateStrengthArray); // $foo is gone
        $AlternateStrengthArray = array(); 
        unset($AlternateDrugArray); // $foo is gone
        $AlternateDrugArray = array();       

       } //end of foreach





		//return $dataAlt;
		//echo json_encode($drugArray);
		// echo $drugString;
		//echo json_encode($AlternateStrength);
		// echo json_encode($dataAlt) ;
	}

	


?>
