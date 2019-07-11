



<input type="text" value=" " id="latitud">
<input type="text" value=" " id="longitud">



<script>

function initMap() {
 
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude        
      };

      
      document.getElementById("latitud").value=position.coords.latitude;
      document.getElementById("longitud").value=position.coords.longitude;

      
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } ;

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
}

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5jO-_P3t6kOroLj8i7oRYl2rqczvMibo&signed_in=false&callback=initMap">
</script>
