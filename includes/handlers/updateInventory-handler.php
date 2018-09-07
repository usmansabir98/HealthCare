<?php 

$modal = "<div id='myModalSuccess' class='modal success-modal'>

            <div class='modal-content'>
              <div class='modal-header bg-success'>
                <h2>Succesful!</h2>

                <span class='close-modal'>&times;</span>
              </div>
              <div class='modal-body p-t-40 p-b-40'>
                <p style='text-align: center;'>Information successfully updated</p>
              
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
                <p style='text-align: center;'>Failed to update information</p>
              
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


function validateEmail($con, $em) {
	$checkEmailuserQuery = mysqli_query($con, "SELECT emailid FROM user WHERE emailid='$em'");
	$checkEmailretailerQuery = mysqli_query($con, "SELECT emailid FROM retailer WHERE emailid='$em'");
	if(mysqli_num_rows($checkEmailuserQuery) != 0 || mysqli_num_rows($checkEmailretailerQuery) != 0) {
		return false;
	}
	return true;
}       

if(isset($_POST['submitChangeName'])){
	$name = strip_tags($_POST['name']);

	$query = mysqli_query($con, "UPDATE retailer SET name='$name' WHERE emailid='$retailerLoggedIn'");

	if($query == true) {
		echo $modal;
    echo $modalScript;
	}
}

if(isset($_POST['submitChangeEmail'])){

	$email = strip_tags($_POST['email']);
	$email = ucfirst(strtolower($email));

	if(validateEmail($con, $email)){
		
		$query = mysqli_query($con, "UPDATE retailer SET emailid='$email' WHERE emailid='$retailerLoggedIn'");
		session_destroy();
		header("Location: ../register.php");
	}

	else{
		echo $modalFailure;
		echo $modalFailureScript;
	}

	
}

if(isset($_POST['submitChangePhone'])){
	$phone = strip_tags($_POST['phone']);

	$query = mysqli_query($con, "UPDATE retailer SET phone='$phone' WHERE emailid='$retailerLoggedIn'");

	if($query == true) {
		echo $modal;
    echo $modalScript;
	}

	
}

if(isset($_POST['submitChangeLocation'])){
	$location = strip_tags($_POST['location']);
	$lat = $_POST['latRetailer'];
	$lng = $_POST['lngRetailer'];


	$query = mysqli_query($con, "UPDATE retailer SET location='$location', latitude='$lat', longitude='$lng' WHERE emailid='$retailerLoggedIn'");

	if($query == true) {
		echo $modal;
    echo $modalScript;
	}
	
}

if(isset($_POST['submitChangeLicense'])){
	$license = strip_tags($_POST['license']);

	$query = mysqli_query($con, "UPDATE retailer SET license='$license' WHERE emailid='$retailerLoggedIn'");

	if($query == true) {
		echo $modal;
    echo $modalScript;
	}
	
}

 ?>