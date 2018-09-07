<?php  
	include("../includes/config.php");
	include("headerSupplierDashboard.php");
	
	include("../includes/classes/Medicine.php");
  include("../includes/classes/Constants.php");
	

	$medicine = new Medicine($con);

	include("../includes/handlers/medicine-handler.php");


?>

<!-- Container fluid  -->
<div class="container-fluid">
    <!-- Start Page Content -->
    <?php include("startPageContent.php"); ?>

        
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-title">
                    <h4>Add a New Medicine Record</h4>
                </div>
                <div class="card-body">
                    <form id="medicineEntryForm" action="addMedicine.php" method="POST" autocomplete="off">
											<label for="brandName">Brand: </label>
											<input type="text" name="brandName" id="brandName" list="brandNameSuggestions">
											<!-- <div id="brandNameSuggestions"></div> -->
											<datalist id="brandNameSuggestions">
												
											</datalist>
											<br><br>

											<label for="numActiveIngredients">No of Active Ingredients: </label>
											<input type="number" name="numActiveIngredients" id="numActiveIngredients">
											<div id="addDrugFields" class="button">Add</div>
											<br><br>

											<input type="hidden" name="numDrugs" id="numDrugs">

											<div id="drugFieldsContainer">
												<!-- for example -->
												<label for="drugName1">Drug Name: </label>
												<input type="text" name="drugName1" id="drugName1" list="drugs1">

												<datalist id="drugs1">

												</datalist>

												<label for="strength1">Strength: </label>
												<input type="text" name="strength1" id="strength1">

												<br><br>
											</div>

											<label for="manufacturer">Manufacturer: </label>
											<input type="text" name="manufacturer" id="manufacturer" list="manufacturerNameSuggestions">
											<datalist id="manufacturerNameSuggestions">
												
											</datalist>
											<br><br>

											<label for="dosageForm">Dosage Form: </label>
											<input type="text" name="dosageForm" id="dosageForm" list="dosageFormSuggestions">
											<datalist id="dosageFormSuggestions">
												
											</datalist>
											<br><br>

											<label for="pack">Packing: </label>
											<input type="text" name="pack" id="pack">
											<br><br>
											<p><?php $medicine->getError(Constants::$duplicateRecord); ?></p>
											<input type="submit" name="medicineEntry">
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

	<script type="text/javascript" src="../includes/assets/js/script.js"></script>
	<script type="text/javascript" src="../includes/assets/js/suggest.js"></script>

	<script type="text/javascript">
				
		let dosage = new Suggest;
		let manufacturer = new Suggest;
		let brand = new Suggest;


		dosage.autoComplete("dosageForm", "dosageFormSuggestions", "addDosageForm.php");
		manufacturer.autoComplete( "manufacturer", "manufacturerNameSuggestions", "addManufacturer.php");
		brand.autoComplete("brandName", "brandNameSuggestions", "addMedicine.php");

					
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


</body>

</html>