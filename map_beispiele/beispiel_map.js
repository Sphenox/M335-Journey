<div id="map" style="max-width: 100%; height: 500px;"></div>
<script src="http://maps.google.com/maps/api/js" type="text/javascript"></script>
<script type="text/javascript">
    // <![CDATA[
    function initialize() {
        //Custom Styles
        var styles = [
            // Hier die Styles der Map eingeben.
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#444444"
                }]
            }, {
                "featureType": "administrative.country",
                "elementType": "labels.text",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "administrative.province",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [{
                    "color": "#f5f5f5"
                }]
            }, {
                "featureType": "landscape",
                "elementType": "labels",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "landscape.man_made",
                "elementType": "all",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "road",
                "elementType": "all",
                "stylers": [{
                    "saturation": -100
                }, {
                    "lightness": 45
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [{
                    "visibility": "simplified"
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "labels",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "water",
                "elementType": "all",
                "stylers": [{
                    "color": "#46bcec"
                }, {
                    "visibility": "on"
                }]
            }
        ];

        var styledMap = new google.maps.StyledMapType(styles, {
            name: "Styled Map"
        });

        // Alle Locations die angezeigt werden
        var locations = [
            ['Bienen Meier AG<br />Fahrbachweg 1<br />CH-5444 Künten<br><br>T 056 485 92 50<br />F 056 485 92 55', 47.3896783, 8.3322119],
            ['Margret Frei<br />Bielstrasse 12<br />CH-3232 Ins<br><br>T 032 313 32 03', 47.0059195, 7.1083073]
        ];

        // Die Map konfigurieren
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: new google.maps.LatLng(46.818188, 8.227512),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        map.mapTypes.set('map_style', styledMap);
        map.setMapTypeId('map_style');

        var gruppe1 = {
            path: 'M-5,0a5,5 0 1,0 10,0a5,5 0 1,0 -10,0',
            fillColor: '#8C2864',
            fillOpacity: 1,
            strokeColor: '#8C2864',
            scale: 3
        };


        var infowindow = new google.maps.InfoWindow();
        var marker, i;


        // Um die ganzen Icons darzustellen
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: grupp1
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    // was machen beim Klick auf die Markierung
                    infowindow.setContent('' + locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    // ]]>
</script>