<?php 

function sanitizeFormPassword($inputText) {
	$inputText = strip_tags($inputText);
	return $inputText;
}

function sanitizeFormUsername($inputText) {
	$inputText = strip_tags($inputText);
	// $inputText = str_replace(" ", "", $inputText);
	return $inputText;
}

function sanitizeFormString($inputText) {
	$inputText = strip_tags($inputText);
	// $inputText = str_replace(" ", "", $inputText);
	$inputText = ucfirst(strtolower($inputText));
	return $inputText;
}



if(isset($_POST['hospitalRegisterButton'])) {
	//Register button was pressed
	$hname = sanitizeFormUsername($_POST['hname']);
	

$hphone = sanitizeFormString($_POST['hphone']);
$hlicense = sanitizeFormString($_POST['hlicense']);
$haddress= sanitizeFormString($_POST['haddress']);


	$hemail = sanitizeFormString($_POST['hemail']);


	$hpw = sanitizeFormPassword($_POST['hpw']);

	$hpw2 = sanitizeFormPassword($_POST['hpw2']);
	$hlat= $_POST['hlat'];
$hlng= $_POST['hlng'];

	$hwasSuccessful = $Haccount->register($hname, $hphone, $hemail,$haddress,$hlat,$hlng, $hlicense, $hpw, $hpw2,
		"1");

	if($hwasSuccessful == true) {
		$_SESSION['userLoggedIn'] = $hemail;
		header("Location: index.php");
	}

}
//for user
if(isset($_POST['UserRegisterButton'])) {
	//Register button was pressed
	$uname = sanitizeFormUsername($_POST['uname']);
	

$uphone = sanitizeFormString($_POST['uphone']);

$uaddress= sanitizeFormString($_POST['uaddress']);


	$uemail = sanitizeFormString($_POST['uemail']);


	$upw = sanitizeFormPassword($_POST['upw']);

	$upw2 = sanitizeFormPassword($_POST['upw2']);
	$ulat= $_POST['ulat'];
$ulng= $_POST['ulng'];


	$uwasSuccessful = $Haccount->register($uname, $uphone, $uemail,$uaddress,$ulat,$ulng," ", $upw, $upw2,"2");

	if($uwasSuccessful == true) {
		$_SESSION['userLoggedIn'] = $uemail;
		header("Location: index.php");
	}

}

//for retailer

if(isset($_POST['RetailerRegisterButton'])) {
	//Register button was pressed
	$name = sanitizeFormUsername($_POST['name']);
	

$phone = sanitizeFormString($_POST['phone']);
$ot = sanitizeFormString($_POST['openingTime']);
$ct = sanitizeFormString($_POST['closingTime']);
$license = $_POST['license'];
$address= sanitizeFormString($_POST['address']);
$lat= $_POST['lat'];
$lng= $_POST['lng'];


	$email = sanitizeFormString($_POST['email']);


	$pw = sanitizeFormPassword($_POST['pw']);

	$pw2 = sanitizeFormPassword($_POST['pw2']);

	// echo $lat." ".$lng;
	$wasSuccessful = $Raccount->register($name, $phone, $email,$address,$lat,$lng, $license, $pw, $pw2,$ot,$ct);

	if($wasSuccessful == true) {
		$_SESSION['retailerLoggedIn'] = $email;
		header("Location: supplier/supplierDashboard.php");
	}

}

?>
