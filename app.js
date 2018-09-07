var map;
var service;
var search;
var place;
var flag;
var lat;
var lng;

searchHospital = document.getElementById('searchHospital');
searchUser = document.getElementById('searchUser');
searchRetailer = document.getElementById('searchRetailer');
submitHospital = document.getElementById('submitHospital');
submitUser = document.getElementById('submitUser');
submitRetailer = document.getElementById('submitRetailer');


function showModal(input){
  var modal = document.getElementById('myModal');

          // Get the button that opens the modal
          var btn = input;

          // Get the <span> element that closes the modal
          var span = document.getElementsByClassName("close-modal")[0];

          // When the user clicks on the button, open the modal 
          // btn.onclick = function() {
              modal.style.display = "block";
          // }

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
}

function submitCallback(search){
  var request = {
    query: search.value,
    fields: ['photos', 'formatted_address', 'name', 'rating', 'opening_hours', 'geometry']
  };
  
  service = new google.maps.places.PlacesService(map);
  service.findPlaceFromQuery(request, callback);
}

submitHospital.addEventListener('click', function(e){
  flag = 'hospital';
  showModal(e.target);
  submitCallback(searchHospital);

  e.preventDefault();
});

submitUser.addEventListener('click', function(e){
  flag = 'user';
  showModal(e.target);

  submitCallback(searchUser);

  e.preventDefault();
});

submitRetailer.addEventListener('click', function(e){
  flag = 'retailer';
  showModal(e.target);

  submitCallback(searchRetailer);

  e.preventDefault();
});


function initMap(lat, lng){
	var mapCenter = new google.maps.LatLng(lat,lng);

	map = new google.maps.Map(document.getElementById('map'), {
    center: mapCenter,
    zoom: 15
  });
}

function createMarker(place) {

    new google.maps.Marker({
        position: place.geometry.location,
        map: map
    });
}

function createMarkerLatLng(lat, lng) {

    new google.maps.Marker({
        position: {lat:lat, lng:lng},
        map: map
    });
}

function callback(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      place = results[i];
      console.log(place);
      lat = place.geometry.location.lat();
			lng = place.geometry.location.lng();
      console.log(lat,lng);
  		initMap(lat, lng);

			createMarker(place);

      if(flag=='hospital'){
        document.getElementById('latHospital').value = String(lat);
        document.getElementById('lngHospital').value = String(lng);
      }
      else if(flag=='user'){
        document.getElementById('latUser').value = String(lat);
        document.getElementById('lngUser').value = String(lng);
      }
      else if(flag=='retailer'){
        document.getElementById('latRetailer').value = String(lat);
        document.getElementById('lngRetailer').value = String(lng);
        console.log(document.getElementById('latRetailer').value);
        console.log(document.getElementById('lngRetailer').value);

      }
    }
  }
}

function activatePlacesSearch(){
	var inputHospital = document.getElementById('searchHospital');
  var inputUser = document.getElementById('searchUser');
  var inputRetailer = document.getElementById('searchRetailer');
  var autocomplete = new google.maps.places.Autocomplete(inputHospital);
  var autocomplete = new google.maps.places.Autocomplete(inputUser);
  var autocomplete = new google.maps.places.Autocomplete(inputRetailer);
  initMap(24.95,67.11);
}