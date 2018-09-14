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

    $username = "923348289867";///Your Username
    $password = "3147";///Your Password
    $mobile = "923348289867";///Recepient Mobile Number
    $sender = "MediQuick";
    $message = $code;

    ////sending sms

    $post = "sender=".urlencode($sender)."&mobile=".urlencode($mobile)."&message=".urlencode($message)."";
    $url = "http://sendpk.com/api/sms.php?username=923348289867&password=3147";
    $ch = curl_init();
    $timeout = 0; // set to zero for no timeout
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $result = curl_exec($ch); 
    /*Print Responce*/
    echo $result; 
	}
	else{
		echo $modalFailure;
    echo $modalFailureScript;
	}

}

?>