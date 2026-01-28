<script src="https://maps.googleapis.com/maps/api/js?key=<?= settingsGet('google-api-key') ?>&language=ro"></script>
<script>
    $(document).ready(function() {
        // Search for address via Google Maps
        $('.button-map').on('click', function() {
            let address = $('#address').val(),
                county = $.trim($('#county_id option:selected').text()),
                city = $.trim($('#city_id option:selected').text());

            if (city) {
                address += ',' + city;
            }

            if (county) {
                address += ',' + county;
            }

            geocodeAddress(address, geocoder, map);
        });
    });

    // Add map
    let map, marker, 
        $mapField = $('#map');
    const geocoder = new google.maps.Geocoder();
    function initializeMap() {
        var latLng = $mapField.data('map').split(',');
        var myLatlng = new google.maps.LatLng(latLng[0], latLng[1]);

        var mapOptions = {
            zoom: $mapField.data('zoom'),
            center: myLatlng,
            clickableIcons: false,
            streetViewControl: false,
            mapTypeControl: false
        }

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        marker = new google.maps.Marker({
            position: myLatlng,
            map: map
        });

        google.maps.event.addListener(map, 'click', function(e) {
            marker.setPosition(e.latLng);
            map.panTo(e.latLng);
            map.setZoom(16);
            $mapField.val(e.latLng.toUrlValue());
        });
    }

    function geocodeAddress(address, geocoder, resultsMap) {
        geocoder.geocode({ address: address, componentRestrictions: { country: 'RO' } }, (results, status) => {
            if (status === "OK") {
                resultsMap.setCenter(results[0].geometry.location);
                resultsMap.setZoom(16);
                marker.setPosition(results[0].geometry.location);
                $mapField.val(results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng());
            } else {
                alert("Adresa nu a fost gasita.");
            }
        });
    }

    initializeMap();
</script>