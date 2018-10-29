
<?php 
global $wpdb;

session_start();
if($_GET['select_country']!='null'){
$_SESSION['prev_country']=$_GET['select_country'];
}
if($_GET['select_timezone']!='null'){
  $_SESSION['prev_timezone']=$_GET['select_timezone'];
}
$countries=$wpdb->get_results("select distinct country from wp_coordinates");
$timezones=$wpdb->get_results("select distinct timezone from wp_coordinates");
$sql_coordinates='select lat, lng, city,population from wp_coordinates where country=\''.$_SESSION['prev_country'].'\' AND lat>'.$_GET['lat_from'].' AND lat<'.$_GET['lat_to'].' AND population>='.$_GET['population_from'].' AND population<='.$_GET['population_to'].' ';
if($_GET['select_city']!=''){
  $sql_coordinates='select lat, lng,city,population from wp_coordinates where city=\''.$_GET['select_city'].'\' ';
}
if($_GET['select_timezone']!='null'){
  $sql_coordinates='select lat, lng,city,population from wp_coordinates where timezone=\''.$_SESSION['prev_timezone'].'\'  AND lat>'.$_GET['lat_from'].' AND lat<'.$_GET['lat_to'].' AND population>='.$_GET['population_from'].' AND population<='.$_GET['population_to'].'';
}

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

<form action="#" method="get">
  <div>
    <select name="select_timezone" id="select_timezone" onchange=" this.form.submit(); initMap()">
    <option value="null" id="default_option_timezone" hidden>Select Timezone</option>
</select>
      <select name="select_country" id="select_country" onchange=" this.form.submit(); initMap()">
    <option value="null" id="default_option_country" hidden>Select Country</option>
</select>
</div>
     <input type="text" id="city" name="select_city" autocomplete="off" list="cities" placeholder="Enter city name" onkeypress="load_cities(this)" >
     <datalist id="cities">
     </datalist>
<label>lat(from-to):</label>

<input type="number" name="lat_from" style="width: 80px" min="-90" max="90" value="-90.0" >
-
<input type="number" name="lat_to" style="width: 80px"   min="-90" max="90" value="90.0">
<label>lng(from-to):</label>

<input type="number" step="0.05" style="width: 80px" name="lng_from" min="-180" max="180" value="-180.0">
-
<input type="number" step="0.05"  style="width: 80px" name="lng_to" min="-180" max="180" value="180.0">
<label>population(from-to):</label>
<input type="number" name="population_from" style="width: 80px"  step="5" min="0" value="0.0" >
-
<input type="number" name="population_to" style="width: 80px"  step="5" min="0"  value="1000000000">
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

   function load_timezones(){
      
          var select_menu = document.getElementById("select_timezone");
         var timezones_string='<?php echo json_encode($timezones)?>';
         var timezones =JSON.parse(timezones_string);
         for(i in timezones){
          var option = document.createElement("option");
option.value=timezones[i]['timezone'];
option.text = timezones[i]['timezone'];
select_menu.add(option, select_menu[i+1]);
         }
      }

                function load_cities(input){  
                  if(input.value.length>=3){
                    



                            jQuery.ajax({
                        type: 'GET',
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        data:{
                        action: 'my_action',
                        country: '<?php echo $_GET['select_country']?>',
                        in:input.value

                        },
                         success: function(cities){
                          select_menu=document.getElementById("cities");


                          select_menu.innerHTML = '';
                          for(i in cities){
                            console.log(cities[i])
                                 var option = document.createElement("option");
                                  option.value=cities[i]['city'];
                                  option.text = cities[i]['city'];
                            select_menu.appendChild(option, select_menu[i]);
                          }


                          
                                            }
                                        })  


                  }
      }

// Initialize and add the map
function initMap() {
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
          infowindow.setContent(crds[i]['city']+'<div>'+crds[i]['population']+'</div>');
          infowindow.open(map, marker);
        }
      })(marker, i));
}
document.getElementById("default_option_country").innerHTML='<?php echo ((isset($_GET['select_country'])&&$_GET['select_country']!='null') ? $_GET['select_country']:'Select country')?>';

document.getElementById("default_option_timezone").innerHTML='<?php echo ((isset($_GET['select_timezone'])&&$_GET['select_timezone']!='null') ? $_GET['select_timezone']:'Select timezone')?>';
}
$(document).ready(load_timezones());
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
