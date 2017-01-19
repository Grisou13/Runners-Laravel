<?php
/**
 * Injected automatically view ApiServiceProvider
 * @var $api Dingo\Api\Routing\Router
 */
$api->get("/",function(){
  return "helloooo";
});
$api->group(["middleware"=>["api.auth"]],function(Dingo\Api\Routing\Router $api){
    $api->get("users/me","UserController@me",["as"=>"api.users.me"]);
    $api->resource("users",'UserController',["as"=>"api"]);
    $api->resource("groups",'GroupController',["as"=>"api"]);
    $api->resource("cars",'CarController', ["as"=>"api","except"=>"delete"]);
    $api->resource("runs",'RunController',["as"=>"api"]);

});

$api->get("test",function(){
    return "
<head>
<script>
var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
      zoom: 8,
      center: latlng
    }
    map = new google.maps.Map(document.getElementById(\"map\"), mapOptions);
  }

  function codeAddress() {
    var address = document.getElementById(\"address\").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
      console.log(results);
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert(\"Geocode was not successful for the following reason: \" + status);
      }
    });
  }
</script>
</head>
<body onload=\"initialize()\">
 <div id=\"map\" style=\"width: 320px; height: 480px;\"></div>
  <div>
    <input id=\"address\" type=\"textbox\" value=\"Sydney, NSW\">
    <input type=\"button\" value=\"Encode\" onclick=\"codeAddress()\">
  </div>
</body>";
});
