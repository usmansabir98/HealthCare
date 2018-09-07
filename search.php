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
	<link rel="stylesheet" type="text/css" href="includes/assets/css/navbar.css">

	
</head>

<body>
	<!-- Navbar -->
		<?php include('includes/navbar.php') ?>
		<!-- Code for Navbar -->
		<!-- <nav id="header" class="navbar navbar-fixed-top">
            <div id="header-container" class="container navbar-container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a id="brand" class="navbar-brand" href="#">Health-Care</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#search">Search</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
 -->


		<!-- Search Box -->
		<div id="search-container">
			<div id="search-heading">
				<h1>Health-Care</h1>
				<h3>Find Medicines Nearby</h3>				
			</div>

			<form action="search.php" method="POST" autocomplete="off">
				<fieldset>
					<div id="search-box">
						<input type="text" name="searchDrug" id="searchDrug" list="drugNameSuggestions" placeholder="Search By Brand Name" autocomplete="off">
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
		<!-- <div id="manufacturer"></div> -->

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
			resultContainer.innerHTML = '';

			// search by Generic code (muneeb)

			if(searchBox.value != ''){

				var url_medicine_name = 'includes/handlers/ajax/genericInfo.php?term=' + searchBox.value ;
				var encodedUrl = encodeURI(url_medicine_name);	
			}

			fetch(encodedUrl)
				.then(function(res){
					return res.json();
				})

				.then(function(data_name_display){
					
					let html='<div class = "main-container-3">';
					data_name_display.forEach(function(d){
						
						html += 
							`
								
									<div class='search-list'>
										<div>${d['brandName']}</div><span>${d['manName']}</span>
									</div>
									<div class='content'></div>
							`;

						});
					html += '</div>';

					resultContainer.innerHTML = html;



					var searchList =	document.querySelectorAll('.search-list');

					searchList.forEach(function(list){
						var content = list.nextElementSibling;

						var url_medicine_info = 'includes/handlers/ajax/brandResults.php?term=' + list.firstElementChild.textContent;
						var encodedUrl_2 = encodeURI(url_medicine_info);

						fetch(encodedUrl_2)
							.then(function(res){
								return res.json();
							})

							.then(function(data){

								var medicineForms = [];

								for (var i = 0 ; i < data.length ; i++){
									
									var formName = data[i]['formName'] ;

									if (medicineForms.includes(formName) == false){
										//Pushing form in the array
										medicineForms.push(formName);
									}
								}

								let html = '';
								for (var a = 0 ; a < medicineForms.length ; a++){
									var medForm = medicineForms[a];
									html += `
										<div class = "medicine-form card card-outline-primary">
											<h1 class = "search-list-2">${medForm}</h1><hr>
											`
									for (var i = 0 ; i < data.length ; i++){

										if (medicineForms[a] == data[i]['formName']){
											
											var medId = data[i]['medId'];
											html +=`
												<a href = "medicine.php?term=${medId}">
												<div class = "medicine-info">
													<div class = "packing">
														<p>${data[i]['pack']}</p>
													</div>
											`

											html += `<div class = "drugs">`;
											for (var j = 0 ; j < data[i]['drugs'].length ; j++ ){
												
												html +=`
													
													<p>${data[i]['drugs'][j]} : ${data[i]['strengths'][j]}</p>
												`
											}
											html+=`</div>`;
											html += 
											`
											</div>
											</a>
											`;
										}
									}

									html +=`							
										</div>
									`;
								}

								content.innerHTML += html;
								// console.log(html);
								
							});

					});

					// console.log(document.querySelectorAll('.content'));
					console.log(document.querySelectorAll('.search-list'));

					var coll = document.getElementsByClassName("search-list");
					var i;

					for (i = 0; i < coll.length; i++) {
					  coll[i].addEventListener("click", function() {
					    this.classList.toggle("active");
					    var content = this.nextElementSibling;
					    console.log(content);
					    console.log(content.style.height);


					    if (content.style.height){
					      content.style.height = null;
					      // content.firstElementChild.style.display = 'none';

					    } else {
					      content.style.height = content.scrollHeight + "px";
					      // content.firstElementChild.style.display = 'block';

					    } 
					    console.log(content);

					  });
					}

						
				});

		}




		function brandResultDisplay(){
			if(searchBox.value != ''){
				var url = 'includes/handlers/ajax/brandResults.php?term=' + searchBox.value ;
				var encodedUrl = encodeURI(url);				
			}
			fetch(encodedUrl)
				.then(function(res){
					return res.json();

				})

				.then(function(data){
					
					let html = '' ;
					var manufacturer = data[0]['manName'];
					var brandName = data[0]['brandName'];

					html = 
					`

					<div id = "main-container">
						<div class = "search-list">
							<div>Brand Name : ${brandName}</div><span>${manufacturer}</span>
						</div>
					`
					;

					var medicineForms = [];

					for (var i = 0 ; i < data.length ; i++){
						
						var formName = data[i]['formName'] ;

						if (medicineForms.includes(formName) == false){
							//Pushing form in the array
							medicineForms.push(formName);
						}
					}


						for (var a = 0 ; a < medicineForms.length ; a++){
						var medForm = medicineForms[a];
						html += `
							<div class = "medicine-form card card-outline-primary">
								<h1 class = "search-list-2">${medForm}</h1>
								`
						for (var i = 0 ; i < data.length ; i++){

							if (medicineForms[a] == data[i]['formName']){
								
								var medId = data[i]['medId'];
								html +=`
									<a href = "medicine.php?term=${medId}">
									<div class = "medicine-info">
										<div class = "packing">
											<p>${data[i]['pack']}</p>
										</div>
								`;

										
								html += `<div class = "drugs">`;
								for (var j = 0 ; j < data[i]['drugs'].length ; j++ ){
									
									html +=`
										<p>${data[i]['drugs'][j]} : ${data[i]['strengths'][j]}</p>
							 			
									`
								}
								html+= '</div>';
								html += 
								`
								</div>
								</a>
								`;
							}
						}




						html +=`							
							</div>
						`;
					}

					html += 
					`

					<div>
					`;
					resultContainer.innerHTML = html;



				});

				

		}
		

		searchButton.addEventListener("click", brandResultDisplay);


		searchBy.forEach(function(rad){
				rad.addEventListener('click', function(e){
				searchBox.value = "";
				resultContainer.innerHTML = "";
				searchBox.placeholder = "Search By " + e.target.value + " Name";

				document.querySelectorAll('datalist').forEach(function(dl){
					dl.innerHTML = '';
				});

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