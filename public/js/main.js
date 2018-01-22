
$(document).ready(function() {

  function initialize() {

    var markers = [];
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
      mapTypeId: google.maps.MapTypeId.ROADMAP,
    });

    var defaultBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(43.6382, -79.4377),
        new google.maps.LatLng(43.6764, -79.3000));
    map.fitBounds(defaultBounds);

    var input = /** @type {HTMLInputElement} */(
        document.getElementById('pac-input'));


    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var searchBox = new google.maps.places.SearchBox(
      /** @type {HTMLInputElement} */(input));

    var markerRed = new google.maps.Marker({
        position: new google.maps.LatLng(43.6542, -79.3900),
        map: map,
        icon: pinRed,
        draggable: true,
        title: 'Red testing marker - draggable'
    });

    var markerBlue = new google.maps.Marker({
        position: new google.maps.LatLng(43.6542, -79.3600),
        map: map,
        icon: pinBlue,
        draggable: true,
        title: 'Blue testing marker - draggable'
    });

    var markerYellow = new google.maps.Marker({
        position: new google.maps.LatLng(43.6652, -79.3900),
        map: map,
        icon: pinYellow,
        draggable: true,
        title: 'Yellow testing marker - draggable'
    });

    var markerBlack = new google.maps.Marker({
        position: new google.maps.LatLng(43.6642, -79.3600),
        map: map,
        icon: pinBlack,
        draggable: true,
        title: 'Black testing marker - draggable'
    });

    google.maps.event.addListener(searchBox, 'places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }
      for (var i = 0, marker; marker = markers[i]; i++) {
        marker.setMap(null);
      }

      // For each place, get the icon, place name, and location.
      markers = [];
      var bounds = new google.maps.LatLngBounds();
      for (var i = 0, place; place = places[i]; i++) {
        var image = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };

        // Create a marker for each place.
        var marker = new google.maps.Marker({
          map: map,
          icon: image,
          title: place.name,
          position: place.geometry.location
        });

        markers.push(marker);

        bounds.extend(place.geometry.location);
      }

      map.fitBounds(bounds);
    });

    google.maps.event.addListener(map, 'bounds_changed', function() {
      var bounds = map.getBounds();
      searchBox.setBounds(bounds);
    });
  }

  google.maps.event.addDomListener(window, 'load', initialize);

  $('h1.title, p.tip, #pac-input').fadeIn();
  
});


