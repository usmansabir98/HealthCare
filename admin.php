<?php  
	include("includes/config.php");
	include("includes/classes/Medicine.php");
   	include("includes/classes/Constants.php");
	
	$medicine = new Medicine($con);

	include("includes/handlers/medicine-handler.php");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Portal</title>
	<link rel="stylesheet" type="text/css" href="includes/assets/css/style.css">
</head>
<body>
	<h1>Add a New Medicine Record</h1>
	<form id="medicineEntryForm" action="admin.php" method="POST" autocomplete="off">
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
		<p><?php echo $medicine->getError(Constants::$duplicateRecord); ?></p>
		<input type="submit" name="medicineEntry">
	</form>
	<script type="text/javascript" src="includes/assets/js/script.js"></script>
	<script type="text/javascript" src="includes/assets/js/suggest.js"></script>

	<script type="text/javascript">
				
		let dosage = new Suggest;
		let manufacturer = new Suggest;
		let brand = new Suggest;


		dosage.autoComplete("dosageForm", "dosageFormSuggestions", "addDosageForm.php");
		manufacturer.autoComplete( "manufacturer", "manufacturerNameSuggestions", "addManufacturer.php");
		brand.autoComplete("brandName", "brandNameSuggestions", "addMedicine.php");

					
	</script>

</body>
</html>