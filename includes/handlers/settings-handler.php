<?php 

$modal = "<div id='myModalSuccess' class='modal success-modal'>

            <div class='modal-content'>
              <div class='modal-header bg-success'>
                <h2>Succesful!</h2>

                <span class='close-modal'>&times;</span>
              </div>
              <div class='modal-body p-t-40 p-b-40'>
                <p style='text-align: center;'>Account settings changed successfully!</p>
              
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
                <p style='text-align: center;'>Failed to update settings</p>
              
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

if(isset($_POST['submitChangePassword'])){

	$oldpw = md5($_POST['oldpw']);
	$newpw = $_POST['newpw'];
	$newpw2 = $_POST['newpw2'];

	$query = mysqli_query($con, "SELECT * FROM retailer WHERE emailid='$retailerLoggedIn' AND password='$oldpw'");

	echo mysqli_num_rows($query);
	if(mysqli_num_rows($query)!=1 || $newpw!=$newpw2){
		echo $modalFailure;
		echo $modalFailureScript;
	}

	else{

		$newpw = md5($newpw);

		$query2 = mysqli_query($con, "UPDATE retailer SET password='$newpw' WHERE emailid='$retailerLoggedIn'");

		if($query2){
			echo $modal;
			echo $modalScript;
		}
	}

}


 ?>