function Zone(zone, website_url) {
    this.zone = zone;
    this.map = null;
    this.website_url = website_url;
    this.icones = {
        default: base_url+'/cities/web/bundles/cities/icones/flats.png',
        paris: base_url+'/cities/web/bundles/cities/icones/eiffel.png',
        bordeaux: base_url+'/cities/web/bundles/cities/icones/bordeaux.png',
        reunion: base_url+'/cities/web/bundles/cities/icones/reunion.png',
    };
    this.geocoder = new google.maps.Geocoder();
    this.initMap();
}
Zone.prototype.initMap = function () {
    var self = this;
    this.geocoder.geocode({
        "address": this.zone.name
    }, function(results, status){
        self.map = new google.maps.Map(document.getElementById('region-maps'), {
            // Center map (but check status of geocoder)
            center: results[0].geometry.location,
            zoom: 7
        });
        self.addBounds(self.map, self.zone.coordinates);
    });
};

Zone.prototype.addBounds = function (map, coords) {

    // Construct the polygon.
    var zoneRegion = new google.maps.Polygon({
        paths: coords,
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35
    });
    zoneRegion.setMap(map);
};

$(document).ready(function(){
    var zone = JSON.parse(region);
    google.maps.event.addDomListener(window, 'load', new Zone(zone, base_url));
});