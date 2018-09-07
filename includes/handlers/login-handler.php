<?php
if(isset($_POST['loginButton'])) {
	//Login button was pressed
	$email = $_POST['loginEmail'];
	$password = $_POST['loginPassword'];

	$Uresult = $Uaccount->login($email, $password);
	$Rresult = $Raccount->login($email, $password);

	if($Uresult == true) {
		// header("Location: index.php");
		$_SESSION['userLoggedIn'] = $email;
		header("Location: search.php");
		
	}
	else if($Rresult == true) {
		// header("Location: index.php");
		$_SESSION['retailerLoggedIn'] = $email;
		// echo "retailer it is";
		header("Location: supplier/supplierDashboard.php");
	}
	

}
?>