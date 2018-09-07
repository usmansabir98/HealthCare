var map;
var mapModal;

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

function initMapModal(lat, lng){
  var mapCenter = new google.maps.LatLng(lat,lng);

  
  mapModal = new google.maps.Map(document.getElementById('mapModal'), {
    center: mapCenter,
    zoom: 15
  });
}

function initMapSupplier(lat, lng){
  var mapCenter = new google.maps.LatLng(lat,lng);

  
  map = new google.maps.Map(document.getElementById('map'), {
    center: mapCenter,
    zoom: 11
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
        map: map,
    });
}

function createMarkerSupplier(lat, lng) {
   
    new google.maps.Marker({
        position: {lat:lat, lng:lng},
        map: map,
        // icon: 'https://cdn2.iconfinder.com/data/icons/health-care-9/512/drugstore-64.png'
        icon: 'includes/assets/images/store-32.png'
    });
}

function createMarkerModal(lat, lng){
   new google.maps.Marker({
        position: {lat:lat, lng:lng},
        map: mapModal
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
  		initMapModal(lat, lng);

			createMarkerModal(lat, lng);

      document.getElementById('latModal').value = String(lat);
      document.getElementById('lngModal').value = String(lng);
    }
  }
}

function activatePlacesSearch(){
	
  var inputRetailer = document.getElementById('location');
  var autocomplete = new google.maps.places.Autocomplete(inputRetailer);

  lat = Number(document.getElementById('latUser').value);
  lng = Number(document.getElementById('lngUser').value);

  console.log(lat, lng);
  initMap(lat,lng);
  initMapModal(lat,lng);

  createMarkerLatLng(lat, lng);
}