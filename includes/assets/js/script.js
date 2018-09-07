const addDrugFields = document.getElementById('addDrugFields');
const drugFieldsContainer = document.getElementById('drugFieldsContainer');

addDrugFields.addEventListener('click', addInputFields);

function addInputFields(){

	drugFieldsContainer.innerHTML = '';

	let val = document.getElementById('numActiveIngredients').value;
	document.getElementById('numDrugs').value = val;

	let html='';

	for(let i=1; i<=val; i++){
		html+=
		`
			<label for="drugName${i}">Drug Name: </label>
			<input type="text" name="drugName${i}" id="drugName${i}" list="drugs${i}">
			<datalist id="drugs${i}"></datalist>
			<label for="strength${i}">Strength: </label>
			<input type="text" name="strength${i}" id="strength${i}">

			<br>
		`;
	}

	drugFieldsContainer.innerHTML = html;

	val = document.getElementById('numDrugs').value;
	console.log(val);

	for (let i = 1; i<= val; i++) {
		let activeIngredients = new Suggest;
		console.log("drugName" + i);
		activeIngredients.autoComplete("drugName" + i,"drugs" + i,"addIngredients.php");
	}
}




