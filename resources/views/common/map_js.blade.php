

<?php $site = 'https:';?>
<?php $link = get_google_maps_link();?>
<script src="<?php echo $link;?>"></script>
<script src="<?php echo $site;?>//cdn.rawgit.com/mahnunchik/markerclustererplus/master/dist/markerclusterer.min.js"></script>
<script src='<?php echo $site;?>//cdn.rawgit.com/printercu/google-maps-utility-library-v3-read-only/master/infobox/src/infobox_packed.js' type='text/javascript'></script>
<?php
$location = null;
$lat = -34.397;
$lng = 150.644;

if($Model_Data->location != Null && $Model_Data->lat != Null &&  $Model_Data->lng != Null)
{
    $location = $Model_Data->location;
    $lat =  $Model_Data->lat;
    $lng =  $Model_Data->lng;
}
?>


<script>
    var map, infoWindow;
    var marker;
    var mycenter =  { lat: <?php echo $lat;?>, lng: <?php echo $lng;?> };
    var map = new google.maps.Map(document.getElementById("mymap"), {
        center: mycenter,
        zoom: 14
    });
    function initMap() {
        new google.maps.Marker({
            map: map,
            position: mycenter,
        });
        infoWindow = new google.maps.InfoWindow;

        bind_autocomplete_search();

        google.maps.event.addListener(map, "click", function(e) {
            latLng = e.latLng;

            console.log(latLng);

            $("#lat").val(e.latLng.lat());
            $("#lng").val(e.latLng.lng());

            // if marker exists and has a .setMap method, hide it
            if (marker && marker.setMap) {
                marker.setMap(null);
            }
            marker = new google.maps.Marker({
                position: latLng,
                map: map
            });
            infoWindow.setPosition(latLng);
            infoWindow.setContent('You have selected:<br>Lat: '+ e.latLng.lat() +'<br>Long: '+e.latLng.lng());
            infoWindow.open(map,marker);
        });

    }

    initMap();

    function bind_autocomplete_search(){

        var options = {
            // types: ["establishment"],
            // componentRestrictions: {country: "om"}
        };

        var input = document.getElementById('searchmap');

        var autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.setComponentRestrictions({
            // country: ["om"],
        });

        autocomplete.bindTo("bounds", map);
        autocomplete.addListener("place_changed", function() {
            var place = autocomplete.getPlace();
            // console.log(place);
            // console.log(place.international_phone_number);
            // console.log(place.geometry.location.lat());

            latLng = place.geometry.location;

            $("#lat").val(place.geometry.location.lat());
            $("#lng").val(place.geometry.location.lng());

            if (marker && marker.setMap) {
                marker.setMap(null);
            }
            marker = new google.maps.Marker({
                position: latLng,
                map: map
            });
            infoWindow.setPosition(latLng);
            infoWindow.setContent('You have selected:<br>Lat: '+ place.geometry.location.lat() +'<br>Long: '+place.geometry.location.lng());
            infoWindow.open(map,marker);

            var request = {
                placeId: place.place_id,
                fields: ['opening_hours']
            };

            service = new google.maps.places.PlacesService(map);

            service.getDetails(request, function(place, status){
                localStorage.setItem("place_working_hours", JSON.stringify(new GoogleWorkingHoursPeriod(place.opening_hours.periods)) );
            });
            map.panTo(place.geometry.location);
            map.setZoom(14);
        });
    }
</script>