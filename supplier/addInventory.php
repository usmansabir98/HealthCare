<?php  
	include("../includes/config.php");
	include("headerSupplierDashboard.php");
	
	include("../includes/classes/Inventory.php");
  include("../includes/classes/Constants.php");
	

	$retailerLoggedIn = '';
	if(isset($_SESSION['retailerLoggedIn'])) {
		$retailerLoggedIn = $_SESSION['retailerLoggedIn'];
		echo "<script>retailerLoggedIn = '$retailerLoggedIn';</script>";
	}

	$inventory = new Inventory($con);

	include("../includes/handlers/inventory-handler.php");


?>

<!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <?php include("startPageContent.php"); ?>

                    
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-title">
                                <h4>Add Medicine To Your Inventory</h4>

                            </div>
                            <div class="card-body">
                                <form id="supplierEntryForm" action="addInventory.php" method="POST" autocomplete="off">

																	<label for="brandNameSupplier">Brand: </label>
																	<input type="text" name="brandNameSupplier" id="brandNameSupplier" list="brandNameSuggestionsSupplier">
																	<datalist id="brandNameSuggestionsSupplier">
																		
																	</datalist>
																	<span class="button" id="selectBrandSupplier">Go</span>
																	<br><br>

																	<div id="medicineDetailsContainer">
																		<label for="manufacturerSupplier">Manufacturer: </label>
																		<select name="manufacturerSupplier" id="manufacturerSupplier">
																			<option disabled selected>Select Manufacturer</option>
																		</select>
																		<br><br>

																		<label for="dosageFormSupplier">Dosage Form: </label>
																		<select name="dosageFormSupplier" id="dosageFormSupplier">
																			<option disabled selected>Select Dosage Form</option>
																		</select>
																		<br><br>

																		
																		<label for="packSupplier">Packing: </label>
																		<select name="packSupplier" id="packSupplier">
																			<option disabled selected>Select Packing</option>
																		</select>
																		<br><br>

																		<input type="hidden" name="numDrugsSupplier" id="numDrugsSupplier">

																		<div id="drugFieldsSupplierContainer">
																			
																			<!-- <label for="drugNameSupplier1">Drug Name: </label>
																			<select name="drugNameSupplier1" id="drugNameSupplier1">
																				<option disabled selected>Select Drug Name</option>
																			</select>
																			<select name="strengthSupplier1" id="strengthSupplier1">
																				<option disabled selected>Select Strength</option>
																			</select>
																			<br><br> -->

																		</div>


																		<label for="itemQuantity">Quantity: </label>
																		<input type="number" name="itemQuantity" id="itemQuantity">
																		<br><br>

																		<input class="button" type="submit" name="submitSupplierItem" id="submitSupplierItem">
																	</div>


																</form>
                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                    <!-- /# column -->
                </div>


                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. Template designed by <a href="#">MUY</a></footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->


    <script type="text/javascript">
		var retailerLoggedIn;

		const brandNameSupplier = document.getElementById('brandNameSupplier');
		const medicineContainer = document.getElementById('medicineDetailsContainer');
		const drugFieldsSupplierContainer = document.getElementById('drugFieldsSupplierContainer');
		medicineContainer.style.display = 'none';

		document.getElementById('selectBrandSupplier')
			.addEventListener('click', function(){
				drugFieldsSupplierContainer.innerHTML = ''; 
				document.getElementById('numDrugsSupplier').value = 0;


				let selectManufacturer = document.getElementById('manufacturerSupplier');
				selectManufacturer.innerHTML = '<option disabled selected>Select Manufacturer</option>';

				let selectDosageForm = document.getElementById('dosageFormSupplier');
				selectDosageForm.innerHTML = '<option disabled selected>Select Dosage Form</option>';

				let selectPack = document.getElementById('packSupplier');
				selectPack.innerHTML = '<option disabled selected>Select Packing</option>';

				if (brandNameSupplier.value != '') {
					var url = '../includes/handlers/ajax/addInventory.php?term=' + brandNameSupplier.value;
					var encodedUrl = encodeURI(url);

					fetch(encodedUrl)
						.then(function(res){
							return res.json();
						})
						.then(function(data){
							// console.log(data);
							let manNames = Array();
							data.forEach(function(d){
								if(manNames.indexOf(d['manName'])==-1)
									manNames.push(d['manName']);
							});		

							
							selectManufacturer.innerHTML = '<option disabled selected>Select Manufacturer</option>';
							manNames.forEach(function(el){
								// console.log(el);
								
								selectManufacturer.insertAdjacentHTML('beforeend', `<option>${el}</option>`);
							});

							let manName;
							selectManufacturer.addEventListener("change", function(e){
								drugFieldsSupplierContainer.innerHTML = '';
								document.getElementById('numDrugsSupplier').value = 0;


								// console.log(e.target.value);
								manName = e.target.value;
								let dosageForms = Array();
								data.forEach(function(d){
									if(dosageForms.indexOf(d['formName'])==-1 && d['manName'] == e.target.value)
										dosageForms.push(d['formName']);
								});	

								
								selectDosageForm.innerHTML = '<option disabled selected>Select Dosage Form</option>';
								dosageForms.forEach(function(el){
									// console.log(el);
									
									selectDosageForm.insertAdjacentHTML('beforeend', `<option>${el}</option>`);
								});
							});


							document.getElementById('dosageFormSupplier').addEventListener("change", function(e){

								drugFieldsSupplierContainer.innerHTML = '';
								document.getElementById('numDrugsSupplier').value = 0;


								// console.log(e.target.value);
								let formName = e.target.value;

								let packs = Array();
								data.forEach(function(d){

									if(packs.indexOf(d['pack'])==-1 && d['formName']==e.target.value){
										packs.push(d['pack'])
									}
								});



								selectPack.innerHTML = '<option disabled selected>Select Packing</option>';
								packs.forEach(function(el){

									selectPack.insertAdjacentHTML('beforeend', `<option>${el}</option>`);
								});
								selectPack.addEventListener("change", function(e){
									// console.log(e.target.value)

									let medIds = Array();
									data.forEach(function(d){
										if(d['pack']==e.target.value && d['formName'] == formName && d['manName'] == manName){
											medIds.push(d['medId']);
										}
									});

									// var medIdsString = encodeURIComponent(JSON.stringify(medIds));

									var url = '../includes/handlers/ajax/addInventory.php?medIds=' + medIds.join(',');
									var encodedUrl = encodeURI(url);

									// console.log(encodedUrl);

									
									fetch(encodedUrl)
										.then(function(res){
											// console.log(res.json());
											// console.log(res.text());
											return res.json();
										})
										.then(function(data){
											console.log(data);

											let drugList = Array();
											let strengths = {};

											const firstMedi = data[0]['medId'];
											data.forEach(function(d){
												if(d['medId']==firstMedi)
													drugList.push(d['drugName']);
											});

											document.getElementById('numDrugsSupplier').value = drugList.length;

											drugList.forEach(function(d){
												strengths[d] = Array();
											});
											
											data.forEach(function(d){
												strengths[d['drugName']].push(d['strength']);
											});

											console.log(drugList);
											let html = ""; let i=1;
											drugList.forEach(function(drug){
												var optionsHTML="";
												strengths[drug].forEach(function(s){
													optionsHTML+= "<option>"+s+"</option>";
												});

												html += 
												`<label for="drugNameSupplier${i}">Drug Name: </label>
													<select name="drugNameSupplier${i}" id="drugNameSupplier${i}">
														<option>${drug}</option>
													</select>
													<select name="strengthSupplier${i}" id="strengthSupplier${i}">
														<option disabled selected>Select Strength</option>
														${optionsHTML}
													</select>
													<br><br>`;

												i++;
											});

											drugFieldsSupplierContainer.innerHTML = html;
										});
									
								});

							});
						});

					medicineContainer.style.display = 'block';
				}
				else{
					// print error
				}
			});

			console.log(retailerLoggedIn);
			

	</script>

	<script type="text/javascript" src="../includes/assets/js/suggest.js"></script>

	<script type="text/javascript">
		let brandSupplier = new Suggest;

		brandSupplier.autoComplete("brandNameSupplier", "brandNameSuggestionsSupplier", "addMedicine.php");
		
	</script>


    
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>


    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>

</body>

</html>