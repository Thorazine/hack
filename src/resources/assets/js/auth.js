 var map,
    address,
    addressLatLng,
    centerLatLng,
    radius,
    marker;

$(document).ready(function() {

	$('#location').click(function(event) {
		$(this).prop('disabled', 'disabled').html('One moment please, requesting location <i class="fa fa-spinner fa-spin"></i>');
		getLocation();
	});

	// if(! $('#latitude').val() && ! $('#longitude').val()) {
	// 	if($('#information').data('accepted')) {
	// 		alert('accepted');
	// 	}
	// 	else {
	// 		// getLocation();
	// 	}
	// }

});


/**
 * Use HTML5 to get the users position
 */
function getLocation() {
	console.log('getLocation');
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {

			$('#latitude').val(position.coords.latitude);
			$('#longitude').val(position.coords.longitude);
			$('.panel').hide();
			$('#submit').prop('disabled', false).text('Submit');
			$('#authentication').fadeIn();

		},
		function(error) {
			showErrorMap();
		});
	}
	else {
		showErrorMap();
	}
}


/**
 * Show the google map is the hmtl5 location fails
 */
function showErrorMap() {

	// load the google map
	getLatLongMapHtml(document.getElementById('error-map'));

	$('#setLocation').click(function(event) {
		setMapLocation($('#locationInput').val(), 1);
	});

	$('#locationInput').keypress(function(e) {
	    if(e.which == 13) {
	        setMapLocation($(this).val(), 1);
	    }
	});

	$('#selectLocation').click(function(event) {
		console.log(addressLatLng);
		$('.panel').hide();
		$('#submit').prop('disabled', false).text('Submit');
		$('#latitude').val(addressLatLng.lat());
		$('#longitude').val(addressLatLng.lng());
		$('#authentication').fadeIn();
	});

	$('.panel').hide();
    $('#error').fadeIn();
}

/**
 * Create the map options
 */
function getLatLongMapHtml(placeholder)
{
	// Load the map options
    var mapOptions = {
        scrollwheel: true,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: true,
        disableDefaultUI: true,
        disableDoubleClickZoom: true,
        draggable: true,
        styles: googleMapsStyle(),
    };

	map = new google.maps.Map(placeholder, mapOptions);

	// find the users location
	getIPLocation();
}

/**
 * Set the users location on the map
 *
 * @param string (address)
 */
function setMapLocation(address, radius)
{

	if(typeof radius == "undefined") {
    	radius = 100;
    }

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        'address': address
    },
    function(results, status) {
        if(status == google.maps.GeocoderStatus.OK) {
            centerLatLng = [results[0].geometry.location.lat(), results[0].geometry.location.lng()];
            addressLatLng = new google.maps.LatLng(centerLatLng[0], centerLatLng[1]);

            $('#latitude').val(centerLatLng[0]);
			$('#longitude').val(centerLatLng[1]);

            map.setCenter(addressLatLng);

            map.setZoom(Math.round(14-Math.log(radius)/Math.LN2));

            setMarker(addressLatLng);

        } else {
            alert('Location not found');
        }
    });

    google.maps.event.trigger(map,'resize');

    google.maps.event.addListener(map, 'click', function(event) {
    	setMarker(event.latLng);
    	$('#latitude').val(event.latLng.lat());
		$('#longitude').val(event.latLng.lng());
	});
}

/**
 * Find the users lat long by IP
 */
function getIPLocation()
{
	$.get("http://ipinfo.io", function (response) {
	    if(response.city && response.region) {
	    	$('#locationInput').val(response.city + ', ' + response.region);
	    	setMapLocation(response.city + ((response.city && response.region) ? ', ' : '') + response.region);
	    }
	    else {
	    	$('#locationInput').val('Amsterdam, NL');
	    	setMapLocation('Amsterdam, NL', 3000);
	    }
	}, "jsonp")
	.fail(function(error) {
		$('#locationInput').val('Amsterdam, NL');
		setMapLocation('Amsterdam, NL', 3000);
	});
}


function setMarker(location)
{
	// remove old marker id there is one
	if(marker) {
        marker.setMap(null);
    }

    // set new marker
    marker = new google.maps.Marker({
        position: location,
        map: map,
    });
}


function googleMapsStyle() {
	return [{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels.text","stylers":[{"visibility":"off"}]}];
}
