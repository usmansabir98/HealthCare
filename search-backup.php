<?php 
	include("includes/config.php");
	// include("includes/classes/Search.php");
   	// include("includes/classes/Constants.php");

   	// $search = new Search($con) ;

   	// include("includes/handlers/search-handler.php");
?>


<!DOCTYPE html>
<html>
<head>
	<title>Search Page</title>

	<!-- Bootstrap CDN -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
	<!-- Google Font link -->
	<link href="https://fonts.googleapis.com/css?family=Do+Hyeon" rel="stylesheet">
	
	<!-- Font Awesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	

	<!-- Link Of Search Page CSS file -->
	<link rel="stylesheet" type="text/css" href="includes/assets/css/search_style.css">
	
</head>

<body>
	<!-- Navbar -->
	<div class="container">
		<!-- Code for Navbar -->
		<?php include("includes/navbar.php") ?>



		<!-- Search Box -->
		<div id="search-container">
			<div id="search-heading">
				<h1>Health-Care</h1>
				<h3>Find Medicines Nearby</h3>				
			</div>

			<form action="search.php" method="POST" autocomplete="off">
				<fieldset>
					<div id="search-box">
						<input type="text" name="searchDrug" id="searchDrug" list="drugNameSuggestions" placeholder="Search By Brand Name">
						<datalist id="drugNameSuggestions">
							
						</datalist>
						<div id="search-button" type="submit" name="searchByDrugName"><i class="fas fa-search"></i>Search</div>

						
					</div>


				</fieldset>
			</form>			
			<div style="display: flex; justify-content: center; margin-top: 20px;">
							<span class="p-r-20">
								<input type="radio" name="searchBy" value="Generic">
									<span style="letter-spacing: 10px;" class="m-r-100">Generic</span>
								</input>
							</span>
							<span style="width: 10%;"></span>
							<span class="p-r-20">
								<input type="radio" name="searchBy" value="Brand" class="m-l-20" checked="true">
									<span style="letter-spacing: 10px;">Brand</span>

								</input>
							</span>
						</div>		
		</div>


		<div id="result-container">
			
		</div>
		<div id="manufacturer"></div>

	</div>


	<script type="text/javascript" src="includes/assets/js/suggest.js"></script>

	<script type="text/javascript">
		const resultContainer = document.getElementById("result-container");

		//Selecting the search button
		const searchButton = document.getElementById('search-button');

		//Selecting the input box
		const searchBox = document.getElementById('searchDrug');

		// selecting the radio group
		searchBy = document.querySelectorAll('input[name="searchBy"]');

		let searchAutocomplete = new Suggest ;
		searchAutocomplete.autoComplete("searchDrug","drugNameSuggestions","addMedicine.php");

		function genericResultDisplay(){
			if(searchBox.value != ''){
				var url = 'includes/handlers/ajax/genericResults.php?term=' + searchBox.value ;
				var encodedUrl = encodeURI(url);				
			}

			fetch(encodedUrl)
			.then(function(res){
				return res.json();

			})
			.then(function(data){
				
				let html = '';
				
				data.forEach(function(d){
					html += 
						`
							<div class='search-list'>
								<div>${d['brandName']}</div><span>${d['manName']}</span>
							</div>
							<div class="info-container"></div>
						`;
				});

				resultContainer.innerHTML = html;

			})
		}

		function brandResultDisplay(){
			if(searchBox.value != ''){
				var url = 'includes/handlers/ajax/brandResults.php?term=' + searchBox.value ;
				var encodedUrl = encodeURI(url);				
			}
			fetch(encodedUrl)
				.then(function(res){
					// console.log(res);
					// console.log(res.json());
					// return res.json();
					return res.json();

				})
				.then(function(data){
					
					var res= document.getElementById("result-container");
					document.getElementById("result-container").innerHTML='';
				
					for (var i = 0 ; i < data.length ; i++){
						document.getElementById("manufacturer").innerHTML= "Manufactured by: " + data[i]['manName'];

						var link = document.createElement('div');
						link.id=data[i]['formId'];
						res.appendChild(link);

            if(link.innerHTML==''){
							link.innerHTML ='-----'+data[i]['formName'] +
							'   Packagings: ';
					  }
            link.innerHTML += data[i]['pack']  ;
												
						for (var j = 0 ; j < data[i]['drugs'].length ; j++ ){
							link.innerHTML += "    Drug: " +
							data[i]['drugs'][j] ;
							link.innerHTML += " Strength: " + data[i]['strengths'][j] ;
						}
						
					}
				})
		}

		searchButton.addEventListener("click", brandResultDisplay);


		searchBy.forEach(function(rad){
			rad.addEventListener('click', function(e){
				console.log(e.target.value);
				searchBox.value = "";
				resultContainer.innerHTML = "";
				searchBox.placeholder = "Search By " + e.target.value + " Name";

				if(e.target.value == "Brand"){

					let searchByBrandName = new Suggest ;

					searchAutocomplete.autoComplete("searchDrug","drugNameSuggestions","addMedicine.php");
					// search by brand code (yusra)

					searchButton.removeEventListener("click", genericResultDisplay);

					searchButton.addEventListener("click", brandResultDisplay);
				}

				else{
					// search by Generic code (muneeb)
					let searchByDrugName = new Suggest ;

					searchAutocomplete.autoComplete("searchDrug","drugNameSuggestions","addIngredients.php");

					searchButton.removeEventListener("click", brandResultDisplay);

					searchButton.addEventListener("click", genericResultDisplay); //End of Muneeb code

				} // End of else case
			});
		});		


			
	</script>
	<script type="text/javascript" src="includes/assets/js/search_script.js"></script>

</body>
</html>


<!-- 

returns medId of those medicines having same drugs
SELECT medId, count(medId) FROM medigeneric WHERE drugId in (5,10) group BY medId having count(medId)=2;

SELECT medId, count(medId) FROM medigeneric WHERE drugId in (26,27) group BY medId having count(medId)=2;

SELECT medId, count(medId) FROM medigeneric WHERE drugId in (29,30) group BY medId having count(medId)=2;



 -->