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

  $queryAll = mysqli_query($con, "SELECT orders.orderId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack, retailer.name, orders.time, orders.quantity, orderstatus.status 
		FROM `orders` 
		INNER JOIN retailer on orders.supplierId = retailer.id
		INNER JOIN orderstatus on orders.status = orderstatus.statusId
		INNER JOIN medicine on orders.medId = medicine.medId
		INNER JOIN brandName on medicine.brandId = brandname.brandId
		INNER JOIN manufacturer on medicine.manId = manufacturer.manId
		INNER JOIN dosageform on medicine.formId = dosageform.formId
		where orders.userId = (SELECT id from user where emailid='$userLoggedIn');
		");

  $queryPending = mysqli_query($con, "SELECT orders.orderId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack, retailer.name, orders.time, orders.quantity, orderstatus.status 
		FROM `orders` 
		INNER JOIN retailer on orders.supplierId = retailer.id
		INNER JOIN orderstatus on orders.status = orderstatus.statusId
		INNER JOIN medicine on orders.medId = medicine.medId
		INNER JOIN brandName on medicine.brandId = brandname.brandId
		INNER JOIN manufacturer on medicine.manId = manufacturer.manId
		INNER JOIN dosageform on medicine.formId = dosageform.formId


		where orders.userId = (SELECT id from user where emailid='$userLoggedIn')
		AND orders.status = (SELECT statusId from orderstatus where status = 'Pending');
		");

  $queryExpired = mysqli_query($con, "SELECT orders.orderId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack, retailer.name, orders.time, orders.quantity, orderstatus.status 
		FROM `orders` 
		INNER JOIN retailer on orders.supplierId = retailer.id
		INNER JOIN orderstatus on orders.status = orderstatus.statusId
		INNER JOIN medicine on orders.medId = medicine.medId
		INNER JOIN brandName on medicine.brandId = brandname.brandId
		INNER JOIN manufacturer on medicine.manId = manufacturer.manId
		INNER JOIN dosageform on medicine.formId = dosageform.formId
		where orders.userId = (SELECT id from user where emailid='$userLoggedIn')
		AND orders.status = (SELECT statusId from orderstatus where status = 'Expired');
		");

  $queryFulfilled = mysqli_query($con, "SELECT orders.orderId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack, retailer.name, orders.time, orders.quantity, orderstatus.status 
		FROM `orders` 
		INNER JOIN retailer on orders.supplierId = retailer.id
		INNER JOIN orderstatus on orders.status = orderstatus.statusId
		INNER JOIN medicine on orders.medId = medicine.medId
		INNER JOIN brandName on medicine.brandId = brandname.brandId
		INNER JOIN manufacturer on medicine.manId = manufacturer.manId
		INNER JOIN dosageform on medicine.formId = dosageform.formId
		where orders.userId = (SELECT id from user where emailid='$userLoggedIn')
		AND orders.status = (SELECT statusId from orderstatus where status = 'Fulfilled');
		");

  $queryUnfulfilled = mysqli_query($con, "SELECT orders.orderId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack, retailer.name, orders.time, orders.quantity, orderstatus.status 
		FROM `orders` 
		INNER JOIN retailer on orders.supplierId = retailer.id
		INNER JOIN orderstatus on orders.status = orderstatus.statusId
		INNER JOIN medicine on orders.medId = medicine.medId
		INNER JOIN brandName on medicine.brandId = brandname.brandId
		INNER JOIN manufacturer on medicine.manId = manufacturer.manId
		INNER JOIN dosageform on medicine.formId = dosageform.formId
		where orders.userId = (SELECT id from user where emailid='$userLoggedIn')
		AND orders.status = (SELECT statusId from orderstatus where status = 'Unfulfilled');
		");


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

	<div id="container3" class="container-order">
		<div id="order-content" class="card">
			<div>
				<h2 style=" display: inline-block;">Track Your Reservations</h2>
				
				<hr>
				<div class="tab">
					<button class="tablinks" onclick="openCity(event, 'all')" id="defaultOpen">All</button>
				  <button class="tablinks" onclick="openCity(event, 'pending')">Pending</button>
				  <button class="tablinks" onclick="openCity(event, 'expired')">Expired</button>
				  <button class="tablinks" onclick="openCity(event, 'fulfilled')">Fulfilled</button>
				  <button class="tablinks" onclick="openCity(event, 'unfulfilled')">Unfulfilled</button>

				</div>

				<div id="all" class="tabcontent">
				  <h3>All Orders</h3>
				  <div class="scroll-div table-responsive">
				  	
				  	<table class="table table-hover">
				  		<thead>
				  			<tr>
				  				<th>#</th>
				  				<th>Supplier</th>
				  				<th>Product</th>
				  				<th>Packing</th>
				  				<th>Qty</th>
				  				<th>Date</th>
				  				<th>Status</th>

				  			</tr>

				  			<?php 

				  			$i =1;

				  			while ($row = mysqli_fetch_array($queryAll)) {
				  				# code.
				  				# code.
				  				$name = $row['name'];
				  				$brandName = $row['brandName'];
				  				$manName = $row['manName'];
				  				$dosageForm = $row['formName'];
				  				$pack = $row['pack'];

				  				$product = $brandName.'<br>'.$manName;
				  				$packing = $pack.'<br>'.$dosageForm;


				  				$quantity = $row['quantity'];
				  				$date = date('Y-m-d', $row['time']);
				  				$time = date('h:i:sa', $row['time']);
				  				$status = $row['status'];
				  				$datetime = $date.'<br>'.$time;

				  				if($status == 'Pending'){
				  					$statusClass = 'status status-primary';
				  				}
				  				else if($status == 'Fulfilled'){
				  					$statusClass = 'status status-success';
				  				}
				  				else if($status == 'Unfulfilled'){
				  					$statusClass = 'status status-danger';
				  				}
				  				else{
				  					$statusClass = 'status status-warning';

				  				}


				  				echo "<tr>

				  					<td>$i</td>
				  					<td>$name</td>
				  					<td>$product</td>
				  					<td>$packing</td>
				  					<td>$quantity</td>
				  					<td>$datetime</td>
				  					<td><span class='$statusClass'>$status</span></td>


				  				</tr>";

				  				$i++;
				  			}

				  			 ?>
				  		</thead>
				  	</table>
				  </div>
				</div>

				<div id="pending" class="tabcontent">
				  <h3>Pending Orders</h3>
				  <div class="scroll-div table-responsive">
				  	<table class="table table-hover">
				  		<thead>
				  			<tr>
				  				<th>#</th>
				  				<th>Supplier</th>
				  				<th>Product</th>
				  				<th>Packing</th>
				  				<th>Qty</th>
				  				<th>Date</th>
				  				<th>Status</th>

				  			</tr>

				  			<?php 

				  			$i =1;

				  			while ($row = mysqli_fetch_array($queryPending)) {
				  				# code.
				  				# code.
				  				$name = $row['name'];
				  				$brandName = $row['brandName'];
				  				$manName = $row['manName'];
				  				$dosageForm = $row['formName'];
				  				$pack = $row['pack'];

				  				$product = $brandName.'<br>'.$manName;
				  				$packing = $pack.'<br>'.$dosageForm;


				  				$quantity = $row['quantity'];
				  				$date = date('Y-m-d', $row['time']);
				  				$time = date('h:i:sa', $row['time']);
				  				$status = $row['status'];
				  				$datetime = $date.'<br>'.$time;

				  				if($status == 'Pending'){
				  					$statusClass = 'status status-primary';
				  				}
				  				else if($status == 'Fulfilled'){
				  					$statusClass = 'status status-success';
				  				}
				  				else if($status == 'Unfulfilled'){
				  					$statusClass = 'status status-danger';
				  				}
				  				else{
				  					$statusClass = 'status status-warning';

				  				}


				  				echo "<tr>

				  					<td>$i</td>
				  					<td>$name</td>
				  					<td>$product</td>
				  					<td>$packing</td>
				  					<td>$quantity</td>
				  					<td>$datetime</td>
				  					<td><span class='$statusClass'>$status</span></td>


				  				</tr>";

				  				$i++;

				  			}

				  			 ?>
				  		</thead>
				  	</table>
				  </div>
				</div>

				<div id="expired" class="tabcontent">
				  <h3>Expired Orders</h3>
				  <div class="scroll-div table-responsive">
				  	<table class="table table-hover">
				  		<thead>
				  			<tr>
				  				<th>#</th>
				  				<th>Supplier</th>
				  				<th>Product</th>
				  				<th>Packing</th>
				  				<th>Qty</th>
				  				<th>Date</th>
				  				<th>Status</th>

				  			</tr>

				  			<?php 

				  			$i =1;

				  			while ($row = mysqli_fetch_array($queryExpired)) {
				  				# code.
				  				# code.
				  				$name = $row['name'];
				  				$brandName = $row['brandName'];
				  				$manName = $row['manName'];
				  				$dosageForm = $row['formName'];
				  				$pack = $row['pack'];

				  				$product = $brandName.'<br>'.$manName;
				  				$packing = $pack.'<br>'.$dosageForm;


				  				$quantity = $row['quantity'];
				  				$date = date('Y-m-d', $row['time']);
				  				$time = date('h:i:sa', $row['time']);
				  				$status = $row['status'];
				  				$datetime = $date.'<br>'.$time;

				  				if($status == 'Pending'){
				  					$statusClass = 'status status-primary';
				  				}
				  				else if($status == 'Fulfilled'){
				  					$statusClass = 'status status-success';
				  				}
				  				else if($status == 'Unfulfilled'){
				  					$statusClass = 'status status-danger';
				  				}
				  				else{
				  					$statusClass = 'status status-warning';

				  				}


				  				echo "<tr>

				  					<td>$i</td>
				  					<td>$name</td>
				  					<td>$product</td>
				  					<td>$packing</td>
				  					<td>$quantity</td>
				  					<td>$datetime</td>
				  					<td><span class='$statusClass'>$status</span></td>


				  				</tr>";

				  				$i++;
				  			}

				  			 ?>
				  		</thead>
				  	</table>
				  </div>
				</div>

				<div id="fulfilled" class="tabcontent">
				  <h3>Fulfilled Orders</h3>
				  <div class="scroll-div table-responsive">
				  	<table class="table table-hover">
				  		<thead>
				  			<tr>
				  				<th>#</th>
				  				<th>Supplier</th>
				  				<th>Product</th>
				  				<th>Packing</th>
				  				<th>Qty</th>
				  				<th>Date</th>
				  				<th>Status</th>

				  			</tr>

				  			<?php 

				  			$i =1;

				  			while ($row = mysqli_fetch_array($queryFulfilled)) {
				  				# code.
				  				$name = $row['name'];
				  				$brandName = $row['brandName'];
				  				$manName = $row['manName'];
				  				$dosageForm = $row['formName'];
				  				$pack = $row['pack'];

				  				$product = $brandName.'<br>'.$manName;
				  				$packing = $pack.'<br>'.$dosageForm;


				  				$quantity = $row['quantity'];
				  				$date = date('Y-m-d', $row['time']);
				  				$time = date('h:i:sa', $row['time']);
				  				$status = $row['status'];
				  				$datetime = $date.'<br>'.$time;

				  				if($status == 'Pending'){
				  					$statusClass = 'status status-primary';
				  				}
				  				else if($status == 'Fulfilled'){
				  					$statusClass = 'status status-success';
				  				}
				  				else if($status == 'Unfulfilled'){
				  					$statusClass = 'status status-danger';
				  				}
				  				else{
				  					$statusClass = 'status status-warning';

				  				}


				  				echo "<tr>

				  					<td>$i</td>
				  					<td>$name</td>
				  					<td>$product</td>
				  					<td>$packing</td>
				  					<td>$quantity</td>
				  					<td>$datetime</td>
				  					<td><span class='$statusClass'>$status</span></td>


				  				</tr>";

				  				$i++;
				  			}

				  			 ?>
				  		</thead>
				  	</table>
				  </div>
				</div>

				<div id="unfulfilled" class="tabcontent">
				  <h3>Unfulfilled Orders</h3>
				  <div class="scroll-div table-responsive">
				  	<table class="table table-hover">
				  		<thead>
				  			<tr>
				  				<th>#</th>
				  				<th>Supplier</th>
				  				<th>Product</th>
				  				<th>Packing</th>
				  				<th>Qty</th>
				  				<th>Date</th>
				  				<th>Status</th>

				  			</tr>

				  			<?php 

				  			$i =1;

				  			while ($row = mysqli_fetch_array($queryUnfulfilled)) {
				  				# code.
				  				# code.
				  				$name = $row['name'];
				  				$brandName = $row['brandName'];
				  				$manName = $row['manName'];
				  				$dosageForm = $row['formName'];
				  				$pack = $row['pack'];

				  				$product = $brandName.'<br>'.$manName;
				  				$packing = $pack.'<br>'.$dosageForm;


				  				$quantity = $row['quantity'];
				  				$date = date('Y-m-d', $row['time']);
				  				$time = date('h:i:sa', $row['time']);
				  				$status = $row['status'];
				  				$datetime = $date.'<br>'.$time;

				  				if($status == 'Pending'){
				  					$statusClass = 'status status-primary';
				  				}
				  				else if($status == 'Fulfilled'){
				  					$statusClass = 'status status-success';
				  				}
				  				else if($status == 'Unfulfilled'){
				  					$statusClass = 'status status-danger';
				  				}
				  				else{
				  					$statusClass = 'status status-warning';

				  				}


				  				echo "<tr>

				  					<td>$i</td>
				  					<td>$name</td>
				  					<td>$product</td>
				  					<td>$packing</td>
				  					<td>$quantity</td>
				  					<td>$datetime</td>
				  					<td><span class='$statusClass'>$status</span></td>


				  				</tr>";

				  				$i++;
				  			}

				  			 ?>
				  		</thead>
				  	</table>
				  </div>
				</div>
			</div>

		</div>
	</div>

	<script type="text/javascript">
		var userLoggedIn;
		function openCity(evt, cityName) {
	    // Declare all variables
	    var i, tabcontent, tablinks;

	    // Get all elements with class="tabcontent" and hide them
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }

	    // Get all elements with class="tablinks" and remove the class "active"
	    tablinks = document.getElementsByClassName("tablinks");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }

	    // Show the current tab, and add an "active" class to the link that opened the tab
	    document.getElementById(cityName).style.display = "block";
	    evt.currentTarget.className += " active";
		}

		document.getElementById('defaultOpen').click();
	</script>




	<script type="text/javascript" src="includes/assets/js/search_script.js"></script>

</body>
</html>