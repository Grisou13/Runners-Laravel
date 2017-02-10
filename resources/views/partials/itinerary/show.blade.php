<div id="map"></div>
<script>
    //will cast $itinerary to json, Thanks eloquent! :)
    var currentRun = <?php echo json_encode($run) ?>;
    //this normally in the future will only use the api, so we already prepare and do requests with the run ID (even though we already have the data)
    var map;
    function searchAdress(term){
        var search = "https://maps.googleapis.com/maps/api/geocode/json?address="+encodeURI(term)+"&components=country:CH&key={{ env("GOOGLE_MAP_API_KEY") }}";
    }
    function searchWaypointFromLatlng(latlng){
        var term = typeof latlng === "object" ? latlng.lat+","+latlng.lng : latlng;
        var search = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+term+"&key={{ env("GOOGLE_MAP_API_KEY") }}";
    }
    function addMarker(latlng){
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: ''
        });
        marker.addEventListener("click",function(e){
            //popup a small text input to add a name
            //post the new name to the waypoint created with this marker
        });
        return marker;
    }
    function addWaypoint(){

    }
    function removeWaypoint(){

    }
    function getWaypoints(){
        api.get("/runs/"+currentRun.id).then(function(response){return JSON.parse(response)})
                .then(function(response){
                    console.log(response);
                    response.waypoints.map(function(waypoint){
                        addMarker(waypoint.latlng)
                    })
                });
    }

    function initMap() {
        // Create a map object and specify the DOM element for display.
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 46.818188, lng: 8.227511999999999},
            scrollwheel: false,
            zoom: 8
        });
        map.addEventListener("click",function(e){
            //query google api to get geocode
            //add waypoint to api
            //add a new waypoint on map with latlng
        })


    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAP_API_KEY") }}&callback=initMap"
        async defer></script>
