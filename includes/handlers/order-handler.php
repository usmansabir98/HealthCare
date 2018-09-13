<?php 


$modal = "<div id='myModalSuccess' class='modal success-modal'>

            <div class='modal-content'>
              <div class='modalheader bg-success'>
                <h2>Succesful!</h2>

                <span class='close-modal'>&times;</span>
              </div>
              <div class='modal-body p-t-40 p-b-40'>
                <p style='text-align: center;'>Order placed successfully</p>
                <div class='p-b-20' style='display: flex; justify-content: center;'>
                  
                  <div class='btn btn-outline btn-rounded btn-dark m-l-10' id='cancel-modal'>Ok, Got It!</div>
                </div>
              </div>
            </div>

          </div>";

$modalScript = "<script>
      setTimeout(function(){
        document.getElementById('myModalSuccess').style.display = 'block';
      }, 800);
      setTimeout(function(){
        document.getElementById('myModalSuccess').style.display = 'none';
      }, 2200);
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