<?php 
	include("includes/config.php");

// USER
	$userLoggedIn = '';
	if(isset($_SESSION['userLoggedIn'])) {
	    $userLoggedIn = $_SESSION['userLoggedIn'];
	    echo "<script>userLoggedIn = '$userLoggedIn';</script>";
	}

	$queryUser = mysqli_query($con, "SELECT * FROM user WHERE emailid='$userLoggedIn'");
  $user = mysqli_fetch_array($queryUser);


  include("includes/handlers/code-handler.php");
  include("includes/handlers/order-handler.php");


  if(isset($_POST['submitChangeLocation'])){
  	$_SESSION['location'] = $_POST['location'];
  	$_SESSION['latUser'] = $_POST['latModal'];
  	$_SESSION['lngUser'] = $_POST['lngModal'];
  	$_SESSION['updated'] = true;
  }
  else if($userLoggedIn != '' && !isset($_SESSION['updated'])){
  	$_SESSION['location'] = $user['location'];
  	$_SESSION['latUser'] = $user['latitude'];
  	$_SESSION['lngUser'] = $user['longitude'];

  }

  if(!isset($_SESSION['location'])){
  	$_SESSION['location'] = "Set Your Location";
  }
  if(!isset($_SESSION['latUser'])){
  	$_SESSION['latUser'] = "24.94412";
  }
  if(!isset($_SESSION['lngUser'])){
  	$_SESSION['lngUser'] = "67.871321";
  }

  
  $location = $_SESSION['location'];
  $lat = $_SESSION['latUser'];
  $lng = $_SESSION['lngUser'];

  // Range
  if(isset($_POST['selectRange'])){
  	$_SESSION['range'] = $_POST['range'];
  }

  if(isset($_SESSION['range'])){
  	$range = $_SESSION['range'];
  }
  else{
  	$range = 10;
  }


// Content
	if(isset($_GET['term'])){
		$medId = $_GET['term'];
	}

	$query = mysqli_query($con, "SELECT medicine.medId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack FROM medicine 
INNER JOIN brandname ON medicine.brandId = brandname.brandId
INNER JOIN manufacturer ON medicine.manId = manufacturer.manId
INNER JOIN dosageform ON medicine.formId = dosageform.formId
 WHERE medicine.medId = $medId");
// confirm($query2);

  if(!$query){
    echo "No data to show.";
    return;
  }

  $data = mysqli_fetch_array($query);
  $query2 = mysqli_query($con, "SELECT genericname.drugName, medigeneric.strength FROM genericname
	  INNER JOIN medigeneric ON genericname.drugId = medigeneric.drugId
	  WHERE medigeneric.medId = '$medId'");

	  $data['drugs'] = array();
	  $data['strengths'] = array();
	  while($row = mysqli_fetch_array($query2)){
	    // array_push($data, $row);
	    array_push($data['drugs'],$row['drugName']);
	    array_push($data['strengths'],$row['strength']);
	  }
    
  // Fetch Suppliers
	  $querySupplier = mysqli_query($con, "SELECT retailer.id, retailer.name, retailer.location, retailer.latitude, retailer.longitude, retailer.openingTime, retailer.closingTime, inventory.quantity
	FROM retailer 
    INNER JOIN	inventory on retailer.id = inventory.supplierId
    WHERE inventory.medId = $medId");

		$dataSupplier = array();
		$destinations = array();

		while($row = mysqli_fetch_array($querySupplier)){
			array_push($dataSupplier, $row);
			array_push($destinations, array($row['latitude'], $row['longitude']));
		}

		$destString = "";
		$i = sizeof($destinations);
		$i--;

		foreach($destinations as $dest){
			$destString .= $dest[0].",".$dest[1];
			if($i>0){

				$destString.="|";
			}
			$i--;
		}
		echo "<script>destString = '$destString';</script>";
		// echo $destString;

	// Fetch Alternatives
	  include("alternateMedicine.php");

	  $inString = "";
	  $i = sizeof($alternate);
	  $i--;

	  foreach($alternate as $alt){
	  	$inString .= $alt;
	  	if($i>0)
	  		$inString .=",";
	  	$i--;
	  }
	  $inString .= ")";

	  $queryAlternate = mysqli_query($con, "SELECT medicine.medId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack FROM medicine 
INNER JOIN brandname ON medicine.brandId = brandname.brandId
INNER JOIN manufacturer ON medicine.manId = manufacturer.manId
INNER JOIN dosageform ON medicine.formId = dosageform.formId
 WHERE medicine.medId IN ($inString");

	  

?>

<!DOCTYPE html>
<html>
<head>
	<title>Medicine Information</title>
	<!-- Bootstrap CDN -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
	<!-- Google Font link -->
	<link href="https://fonts.googleapis.com/css?family=Do+Hyeon" rel="stylesheet">
	
	<!-- Font Awesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	
	<!-- Link Of Search Page CSS file -->
	<link rel="stylesheet" type="text/css" href="includes/assets/css/medicine.css">
</head>
<body>
	<!-- Navbar -->
	<?php include("includes/navbar.php") ?>

	<!-- Content -->

	<div id="container1" class="container-location">
		<div id="left">
			<span>
				<!-- <label for="searchLocation">Location</label> <br>
				<input type="text" name="searchLocation" id="searchLocation"> -->
				<div id="myModal" class="modal">

	        <div class="modal-content">
	          <div class="modal-header bg-warning">
	            <h4>Update Your Location</h4>

	            <span class="close-modal">&times;</span>
	          </div>
	          <div class="modal-body">
	            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
	              
	              <div class="p-t-20" style="display: flex; justify-content: center;">
	                <input type="text" name="location" id="location" class="m-r-10" style="width: 70%">
	                <input type="text" name="latModal" id="latModal" style="display: none;">
	                <input type="text" name="lngModal" id="lngModal" style="display: none;">
	                <div id="setLocation" class="m-l-10 btn btn-outline btn-rounded btn-info">Set Location</div>
	              
	              </div>

	              <div id="mapModal" style="height: 250px; width: 80%; margin: 20px auto;"></div>
	              
	              <div class="p-b-20" style="display: flex; justify-content: center;">
	                <input type="submit" name="submitChangeLocation" class="btn btn-rounded btn-success btn-outline" style="padding: 0 auto;" value="Update Location">
	                <div class="btn btn-outline btn-rounded btn-dark m-l-10" id="cancel-modal">Cancel</div>
	              </div>
	            </form>
	          </div>
	        </div>

	      </div>

				<div class="search-box">
						<input type="text" name="searchLocation" id="searchLocation" placeholder="Search Location" disabled value=" <?php echo $location; ?> ">


						<input type="hidden" name="latUser" id="latUser" value="<?php echo $lat; ?>">
						<input type="hidden" name="lngUser" id="lngUser" value="<?php echo $lng; ?>">

						
						<button id="search-button" type="submit" name="updateLocation"><i class="fa fa-globe"></i>Update</button>

						
					</div>
			</span>	
		</div>

		<div id="right">
			<!-- <label for="range">Select Range in KM</label> -->
			<div class="search-box">
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
					<input type="number" name="range" id="range" placeholder="Select Range in KM" value="<?php echo $range; ?>">
					<button type="submit" name="selectRange" id="selectRange"><i class="fa fa-globe"></i>Update</button>
				</form>
				<!-- <div type="submit" name="selectRange" id="selectRange" value="Update"> -->
			</div>
			
		</div>

	</div>

	<div id="container2" class="container-content">
		<div id="left" class="card">
			<h4 style=" display: inline-block;" class="card-title"><?php echo $data['brandName']; ?></h4>
			<h6 style="letter-spacing: 2px; display: inline-block; float: right"><?php echo $data['manName']; ?></h6>
			<hr>
			<span><?php echo $data['formName']; ?></span>
			<span style="float: right"><?php echo $data['pack']; ?></span>
			<div class="scroll-div">
				<?php 
				for ($i=0; $i<sizeof($data['drugs']) ; $i++) { 
					$d= $data['drugs'][$i];
					$s= $data['strengths'][$i];
					echo "<div><span>$d</span>";
					echo "<span style='float:right;'>$s</span></div>";
				}
			?>
			</div>
		</div>
		<div id="middle" class="card">
			<h4 class="card-title">
				Select Supplier
			</h4>
			<hr>
			<div class="scroll-div">
				<?php 
					// while($row = mysqli_fetch_array($querySupplier)){
					// 	$name = $row['name'];
					// 	$location = $row['location'];
					// 	echo "<div class='supplier-list'>
					// 				<span>$name</span><br>
					// 				<span>$location</span>
					// 			</div>";
					// }

					foreach ($dataSupplier as $d) {
						$name = $d['name'];
						$location = $d['location'];
						$latitude = $d['latitude'];
						$longitude = $d['longitude'];

						$supplierId = $d['id'];
						$timing = substr($d['openingTime'], 0,5).' - '. substr($d['closingTime'], 0, 5);
						$quantity = $d['quantity'];

							echo "<div class='supplier-list'>
					 				<div>
					 					<span>$name</span><br>
					 					<span>$location</span>
					 					<span style='display:none'>$supplierId</span>
					 					<span style='display:none'>$timing</span>
					 					<span style='display:none'>$quantity</span>
					 					<span style='display:none'>$latitude</span>
					 					<span style='display:none'>$longitude</span>



					 				</div>
					 				<div style='float: right;'>
					 					<span class='distance'></span>
					 					<span class='time'></span>
					 				</div>

					 			</div>";

					}
				?>
			</div>
		</div>
		<div id="right" class="card">
			<h4 class="card-title">
				Find Alternatives
			</h4>
			<hr>

			<div id="alternate-list" class="scroll-div">
				<?php 
				if($queryAlternate){
					while($row = mysqli_fetch_array($queryAlternate)){
						$brandName = $row['brandName'];
						$manName = $row['manName'];
						$medId = $row['medId'];
						echo "<a href='medicine.php?term=$medId'><div class='alternate-list'>
									<span>$brandName</span><br>
									<span>$manName</span>
								</div></a>";
					}
				}
				else{
					echo "<span>No substitutes Available</span>";
				}
			?>
			</div>
		</div>
	</div>

	<div id="container3" class="container-content">
		<div id="left" class="card">
			<div>
				<h4 style=" display: inline-block;" class="card-title">Supplier</h4>
				<h4 style="letter-spacing: 2px; display: inline-block; float: right"><span style="float: right" id="supplierDistance">0 Km</span><br>From Current Location</h4>
				<hr>
				<h4 id="supplierError">No Supplier Selected</h4>
				<h2 id="supplierName"></h2>
				<h4 id="supplierLocation"></h4>
				<h4 id="supplierTiming"></h4>

				<h4 id="supplierAvailability"></h4>
				<h4 id="reserveOrderError"></h4>
			</div>

			<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="reserveOrderForm">
				
			</form>
		</div>
		
		<div id="right" class="card">
			<div id="map"></div>
		</div>
	</div>

	<script type="text/javascript">
		var userLoggedIn;

		
		var destString;
		console.log(userLoggedIn);
		console.log(destString);

		var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("search-button");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-modal")[0];

    // When the user clicks on the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    document.getElementById('cancel-modal').onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }


    // GOOGLE DISTANCE MATRIX

    var latUser = document.getElementById('latUser').value;
    var lngUser = document.getElementById('lngUser').value;


    let url = `https://maps.googleapis.com/maps/api/distancematrix/json?origins=${latUser},${lngUser}&destinations=${destString}&key=AIzaSyC-0ff6dw9PJbMb-28OlWi5Oz9igGeATcM`;
    encodedURL = encodeURI(url);
    console.log(encodedURL);

    if(destString!='')
    fetch(encodedURL)
    	.then(function(res){
    		return res.json();
    	})
    	.then(function(data){
    		console.log(data);
    		console.log(data['destination_addresses']);
    		console.log(data['rows']);

    		var distance = document.querySelectorAll('.distance');
    		var time = document.querySelectorAll('.time');
    		var supplierList = document.querySelectorAll('.supplier-list');
    		var rangeInKm = document.getElementById('range');
    		rangeInKm = Number(rangeInKm.value);




    		for(var i=0; i<data['destination_addresses'].length; i++){
    			var distanceInMeters = data['rows'][0]['elements'][i]['distance']['value'];
    			
    			if(distanceInMeters>(rangeInKm*1000)){
    				supplierList[i].style.display = 'none';
    			}
    			else{
    				supplierList[i].style.display = 'block';    				
    			}
    			distance[i].textContent = data['rows'][0]['elements'][i]['distance']['text'];
    			time[i].textContent = data['rows'][0]['elements'][i]['duration']['text'];
    		}

    		function supplierCallback(){
    			var name = this.firstElementChild.firstElementChild;
    			var distance = this.lastElementChild.firstElementChild;

    			var location = name.nextElementSibling.nextElementSibling;
    			var id = location.nextElementSibling;
    			var timing = id.nextElementSibling;
    			var quantity = timing.nextElementSibling;
    			let lat = quantity.nextElementSibling;
    			let lng = lat.nextElementSibling;

    			console.log(lat.textContent, lng.textContent);

    			document.getElementById('supplierError').textContent = '';
    			document.getElementById('supplierName').textContent = name.textContent;
    			document.getElementById('supplierLocation').textContent = location.textContent;
    			document.getElementById('supplierTiming').textContent = timing.textContent;
    			document.getElementById('supplierDistance').textContent = distance.textContent;

    			if(Number(quantity.textContent)>0){
    				document.getElementById('supplierAvailability').innerHTML = `Availability:<span style="float: right" class="badge bg-success">IN STOCK</span>`;

    				document.getElementById('reserveOrderForm').innerHTML = 
    					`<input type="hidden" name="supplierId" value="${id.textContent}">
				<label for="qty">Select Quantity</label>
				<input type="number" name="qty" id="qty">
				<button type="submit" name="reserveOrder" id="reserveOrder" class="btn btn-rounded btn-outline btn-success" style='width:100%; margin-top:20px;'>RESERVE ORDER</button>`;
    			}
    			else{
    				document.getElementById('supplierAvailability').innerHTML = `Availability:<span style="float: right" class="badge bg-warning">OUT OF STOCK</span>`;
    			}

    			if(userLoggedIn){
						document.getElementById('reserveOrderError').textContent = '';
						document.getElementById('reserveOrderForm').style.display = 'block';
					}
					else{
						document.getElementById('reserveOrderForm').style.display = 'none';
						document.getElementById('reserveOrderError').textContent = 'Want to reserve your medicine? Log in now!';

						document.getElementById('reserveOrderError').style.alignText = 'center';

					}

    			initMapSupplier(Number(lat.textContent), Number(lng.textContent));

    			createMarkerSupplier(Number(lat.textContent), Number(lng.textContent));
    			createMarkerLatLng(Number(document.getElementById('latUser').value), Number(document.getElementById('lngUser').value));

    		}

    		supplierList.forEach(function(supplier){
    			supplier.addEventListener('click', supplierCallback);

    		});

    	});

  //   var restRequest = gapi.client.request({
		//   'path': 'https://maps.googleapis.com/maps/api/distancematrix/json',
		//   'params': {'origins': `${latUser},${lngUser}`,
		//   						'destinations': `${destString}`,
		//   						'key': 'AIzaSyC-0ff6dw9PJbMb-28OlWi5Oz9igGeATcM'
		// 						}
		// });

		// console.log(restRequest);
	</script>




	<script type="text/javascript" src="includes/assets/js/search_script.js"></script>

	<script type="text/javascript" src="includes/assets/js/medicine.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-0ff6dw9PJbMb-28OlWi5Oz9igGeATcM&libraries=places&callback=activatePlacesSearch"></script>

</body>
</html>