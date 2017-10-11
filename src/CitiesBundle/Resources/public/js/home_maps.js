function Gmaps(data) {
    this.map = null;
    this.data = data;
    this.initMap();
    this.geocoder = new google.maps.Geocoder();
    this.showCities();
}
Gmaps.prototype.initMap = function () {
    var center = {lat: 48.862725, lng: 2.287592000000018};
    this.map = new google.maps.Map(document.getElementById('gmaps'), {
        zoom: 6,
        center: center
    });
};
Gmaps.prototype.showCities = function () {
    var data = this.data;
    if (this.data instanceof Array) {
        for (index in data) {
            var ville = data[index];
            this.geocodeCity(ville, this.map);
        }
    }
};

Gmaps.prototype.geocodeCity = function (ville, map) {
    var self = this;
    this.geocoder.geocode({'address': ville.name}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var LatLng = results[0].geometry.location;
            var marker = new google.maps.Marker({
                position: LatLng,
                title: "Population "+ville.numberPopulation
            });
            marker.setMap(map);
            var infowindow = new google.maps.InfoWindow({
                content: 'Voir <a href="">'+ville.name+'</a>'
            });
            marker.addListener('click', function(){
                infowindow.open(map, marker);
            });
        } else {
            if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                console.log("Error, OVER_QUERY_LIMIT "+status);
                setTimeout(function(){
                    self.geocodeCity(ville, map);
                },1000);
            } else {
                var reason="Code "+status;
                console.log(reason);
            }
        }
    });
};

$(document).ready(function(){
    json_villes = JSON.parse(json_villes);
    google.maps.event.addDomListener(window, 'load', new Gmaps(json_villes));
});