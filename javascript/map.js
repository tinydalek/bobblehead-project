function myMap() {
    var mapCanvas = document.getElementById("map");
    var mapOptions = {
        center: new google.maps.LatLng(-33.88, 151.20), zoom: 14
    };
    var map = new google.maps.Map(mapCanvas, mapOptions);
}