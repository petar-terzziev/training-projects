
<?php 
global $wpdb;

$countries=$wpdb->get_results("select distinct country from wp_coordinates");
$cur_country=$_POST['select_country'];
$sql_coordinates='select lat, lng, city from wp_coordinates where country=\''.$cur_country.'\' AND lat>'.$_POST['lat_from'].' AND lat<'.$_POST['lat_to'].'';
if($_POST['select_city']!=''){
  $sql_coordinates='select lat, lng,city from wp_coordinates where city=\''.$_POST['select_city'].'\'';
}
$sql_cities=' select distinct city from wp_coordinates where country=\''.$cur_country.'\'';

$cities=$wpdb->get_results($sql_cities);

$coordinates=$wpdb->get_results($sql_coordinates);
?>

 <?php the_content(); ?>

<html>
  <head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>
  </head>
  <body>
     <h3>My Google Maps Demo</h3>
     <div>
     	<p>Choose country:</p>

<form action="#" method="post">
      <select name="select_country" id="select_country" onchange=" this.form.submit(); initMap()">
    <option value="null" id="default_option_country" selected>Select Country</option>
</select>
     <input type="text" id="city" name="select_city" list="cities" >
     <datalist id="cities">
     </datalist>
<label>lat(from):</label>
<input type="number" name="lat_from" step="0.05" min="0" max="90" value="0.0" >

<label>lat(to):</label>
<input type="number" name="lat_to" step="0.05" min="0" max="90" value="90.0">
<label>lng(from):</label>

<input type="number" step="0.05" name="lng_from" min="0" max="90" value="0.0">

<label>lng(to):</label>

<input type="number" step="0.05" name="lng_to" min="0" max="90" value="90.0">


<input type="submit" value="Submit">
</form>
</div>
    <!--The div element for the map -->
    <div id="map"></div>

     <script>
     	function load_countries(){
      
     			var select_menu = document.getElementById("select_country");
         var countries_string='<?php echo json_encode($countries)?>';
         var countries =JSON.parse(countries_string);
         for(i in countries){
          var option = document.createElement("option");
option.value=countries[i]['country'];
option.text = countries[i]['country'];
select_menu.add(option, select_menu[i+1]);
         }

     	}
           function load_cities(){
          var select_menu=document.getElementById("cities");
         var cities_string='<?php echo json_encode($cities, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)?>';
         var cities=JSON.parse(cities_string);
      for(i in cities){
             var option = document.createElement("option");
option.value=cities[i]['city'];
select_menu.appendChild(option, select_menu[i+1]);

      }
    
      }

   
// Initialize and add the map
function initMap() {
 var sth='<?php echo $_POST['lat_from']?>';
 console.log(sth);
  // The location of Uluru
  var uluru = {lat: -25.344, lng: 131.036};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 4, center: uluru});
   var markers=Array();
            
    var crds_str='<?php echo json_encode($coordinates, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)?>';
    var crds=JSON.parse(crds_str);
    var infoWindows=Array();
for(i in crds){
    marker= new google.maps.Marker({
            position: {lat: parseFloat(crds[i]['lat']),lng: parseFloat(crds[i]['lng'])},
            map: map,
            title: "collection" 
    });
    var infowindow=new google.maps.InfoWindow();
   google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(crds[i]['city']);
          infowindow.open(map, marker);
        }
      })(marker, i));


}
}
$(document).ready(load_cities());
$(document).ready(load_countries());

    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAutW-KzdxV_So564MrGUM3qQtNNqNE8Gg&callback=initMap">
    </script>
  </body>
</html> 
