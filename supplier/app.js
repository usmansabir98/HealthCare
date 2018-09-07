var map;
var service;
var search;
var place;
var flag;
var lat;
var lng;



function submitCallback(search){
  var request = {
    query: search.value,
    fields: ['photos', 'formatted_address', 'name', 'rating', 'opening_hours', 'geometry']
  };
  
  service = new google.maps.places.PlacesService(map);
  service.findPlaceFromQuery(request, callback);
}

document.getElementById('setLocation').addEventListener('click', function(e){
  // flag = 'hospital';
  submitCallback(document.getElementById('location'));

  e.preventDefault();
});


function initMap(lat, lng){
	var mapCenter = new google.maps.LatLng(lat,lng);

	map = new google.maps.Map(document.getElementById('map'), {
    center: mapCenter,
    zoom: 15
  });
  console.log(document.getElementById('map'));
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

      document.getElementById('latRetailer').value = String(lat);
      document.getElementById('lngRetailer').value = String(lng);
    }
  }
}

function activatePlacesSearch(){
	
  var inputRetailer = document.getElementById('location');
  var autocomplete = new google.maps.places.Autocomplete(inputRetailer);

  lat = Number(document.getElementById('lat').textContent);
  lng = Number(document.getElementById('lng').textContent);

  console.log(lat, lng);
  initMap(lat,lng);
  createMarkerLatLng(lat, lng);
}