function Gmaps(data, website_url) {
    this.map = null;
    this.data = data;
    this.website_url = website_url;
    this.icones = {
      default: base_url+'/cities/web/bundles/cities/icones/flats.png',
      paris: base_url+'/cities/web/bundles/cities/icones/eiffel.png',
      bordeaux: base_url+'/cities/web/bundles/cities/icones/bordeaux.png',
      reunion: base_url+'/cities/web/bundles/cities/icones/reunion.png',
    };
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
            this.buildCityMarker(ville, this.map);
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
                title: "Population "+ville.numberPopulation,
                icon: self.chooseIcon(ville)
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

Gmaps.prototype.buildCityMarker = function(ville, map) {
    console.log(ville);
    var self = this;
    if (parseFloat(ville.latitude) == 0 && parseFloat(ville.longitude) == 0) {
        self.geocodeCity(ville, map);
    } else {
        var LatLng = new google.maps.LatLng({lat: parseFloat(ville.latitude), lng: parseFloat(ville.longitude)});
        var marker = new google.maps.Marker({
            position: LatLng,
            title: "Population " + ville.numberPopulation,
            icon: self.chooseIcon(ville)
        });
        marker.setMap(map);
        var infowindow = new google.maps.InfoWindow({
            content: 'Voir <a href="'+domain_url+'/'+ville.regionSlug+'/'+ville.departementSlug+'/'+ville.slug+'">' + ville.name + '</a>'
        });
        marker.addListener('click', function () {
            infowindow.open(map, marker);
        });
    }
};

/**
 * todo icone pour les villes supérieurs a 500 000 habitants
 * @param ville
 * @returns {*}
 */
Gmaps.prototype.chooseIcon = function(ville) {
    switch (ville.code_insee) {
        case "75056":
            return this.icones.paris;
        break;
        case "33063":
            return this.icones.bordeaux;
        break;
        case "97415":
            return this.icones.reunion;
        break;
        default :
            return this.icones.default;
        break;
    }
};

$(document).ready(function(){
    json_villes = JSON.parse(json_villes);
    google.maps.event.addDomListener(window, 'load', new Gmaps(json_villes, base_url));
});