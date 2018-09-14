<?php 




$modalScript = "<script>


      setTimeout(function(){
        document.getElementById('myModalSuccess').style.display = 'block';
      }, 800);
      
      document.getElementById('cancel-modal').addEventListener('click', function(){
        document.getElementById('myModalSuccess').style.display = 'none';
      });
    </script>";


$modalFailure = "<div id='myModalFailure' class='modal success-modal'>

            <div class='modal-content'>
              <div class='modal-header bg-danger'>
                <h2 style='color: white;'>Failed!</h2>

                <span class='close-modal'>&times;</span>
              </div>
              <div class='modal-body p-t-40 p-b-40'>
                <p style='text-align: center;'>Failed to place order</p>
              
              </div>
            </div>

          </div>";

$modalFailureScript = "<script>
      setTimeout(function(){
        document.getElementById('myModalFailure').style.display = 'block';
      }, 800);
      setTimeout(function(){
        document.getElementById('myModalFailure').style.display = 'none';
      }, 2200);
    </script>";


if(isset($_POST['reserveOrder'])){

	$medId = $_GET['term'];
	$userId = $user['id'];
	$supplierId = $_POST['supplierId'];
	$quantity = $_POST['qty'];
	$time = time();

	$query = mysqli_query($con, "INSERT INTO orders VALUES('', '$medId', '$userId', '$supplierId', '$quantity', '$time', 1);");
  $lastId = mysqli_insert_id($con);

  $code = generateCode($lastId, 5);

  $modal = "<div id='myModalSuccess' class='modal success-modal'>

            <div class='modal-content'>
              <div class='modalheader bg-success'>
                <h2>Succesful!</h2>

                
              </div>
              <div class='modal-body p-t-40 p-b-40'>
                <p style='text-align: center;'>Order placed successfully</p>
                <p style='text-align: center;'>Confirmation Code</p>
                <p style='font-size: 44px; text-align: center;'>$code</p>
                <div class='p-b-20' style='display: flex; justify-content: center;'>
                  
                  <div class='btn btn-outline btn-rounded btn-success' style='width:90%; margin-bottom: 20px;' id='cancel-modal'>ACCEPT</div>
                </div>
              </div>
            </div>

          </div>";

	if($query == true) {
		echo $modal;
    echo $modalScript;
	}
	else{
		echo $modalFailure;
    echo $modalFailureScript;
	}

}

?>