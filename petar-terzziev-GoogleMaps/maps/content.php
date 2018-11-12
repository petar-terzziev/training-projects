
<?php 
global $wpdb;

$countries=$wpdb->get_results("select distinct country from wp_coordinates"); // TODO da go mahna
$timezones=$wpdb->get_results("select distinct timezone from wp_coordinates");
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

  <div>
    <select name="select_timezone" id="select_timezone" onchange="load_countries()">
    <option value="null" id="default_option_timezone" >Select Timezone</option>
</select>
      <select name="select_country" id="select_country" >
    <option value="null" id="default_option_country" >Select Country</option>
</select>
</div>
     <input type="text" id="city" name="select_city" autocomplete="off" list="cities" placeholder="Enter city name" onkeypress="load_cities(this)" >
     <datalist id="cities">
     </datalist>
     <div>
<label>lat(from-to):</label>

<input type="number" name="lat_from" step="0.001" id="lat_from" style="width: 80px" min="-90" max="90" >
-
<input type="number" name="lat_to" id="lat_to" step="0.001" style="width: 80px"   min="-90" max="90" >
</div>
<div>
<label>lng(from-to):</label>

<input type="number" step="0.001" style="width: 80px" name="lng_from" id="lng_from" min="-180" max="180" >
-
<input type="number" step="0.001"  style="width: 80px" name="lng_to" id="lng_to" min="-180" max="180" >
</div>
<div>
<label>population(from-to):</label>
<input type="number" name="population_from" id="population_from" style="width: 80px"  step="1" min="0"  >
-
<input type="number" name="population_to" id="population_to" style="width: 80px"  step="1" min="0"  >
</div>
<input type="submit" value="Submit" onclick="initMap()">  
<p id="query_results_info"></p>
</div>
    <!--The div element for the map -->
    <div id="map"></div>

     <script>





      function load_countries(){

  
          var select_menu = document.getElementById("select_country");
         if(select_menu.selectedIndex!="0") select_menu.remove(select_menu.selectedIndex);
         
          for (i=1;i<select_menu.options.length;i++){
        
            select_menu.remove(i);
            i--;
          }
      
                            jQuery.ajax({
                        type: 'GET',
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>', // TODO da nqma php 
                        data:{
                        action: 'load_countries',
                        timezone: document.getElementById("select_timezone").value

                        },
                         success: function(counties){  // todo error handling


                          
                          for(i in counties){
                  
                                 var option = document.createElement("option");
                                  option.value=counties[i]['country'];
                                  option.text = counties[i]['country'];
                            select_menu.appendChild(option, select_menu[i+1]);
                            if(select_menu[i+1]==localStorage.getItem('country')){
  select_menu.selectedIndex=i+1;
}
                          }


                          
                                            }
                                        })  

  
      }

   function load_timezones(){
      
 localStorage.setItem('country',document.getElementById("select_country").value);
          var select_menu = document.getElementById("select_timezone");
         var timezones_string='<?php echo json_encode($timezones)?>';
         var timezones =JSON.parse(timezones_string);
         for(i in timezones){
          var option = document.createElement("option");
option.value=timezones[i]['timezone'];
option.text = timezones[i]['timezone'];
select_menu.add(option, select_menu[i+1]);
if(timezones[i]['timezone']==localStorage.getItem('timezone')){
  select_menu.selectedIndex=i+1;

}
         }
      }

                function load_cities(input){  
                  if(input.value.length>=3){
                    



                            jQuery.ajax({
                        type: 'GET',
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        data:{
                        action: 'my_action',
                        country: document.getElementById("select_country").value,
                        in:input.value

                        },
                         success: function(cities){
                          select_menu=document.getElementById("cities");


                          select_menu.innerHTML = '';
                          for(i in cities){
                  
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
  var center = {lat: 34.344, lng: 120.036};
  localStorage.setItem('timezone',document.getElementById("select_timezone").value);
 if(document.getElementById("city").value!='') localStorage.setItem('city',document.getElementById("city").value);
 

                            jQuery.ajax({
                        type: 'GET',
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        data:{
                        action: 'my_action2',
                        country: document.getElementById("select_country").value,
                        timezone: document.getElementById("select_timezone").value,
                        city: document.getElementById("city").value,
                        latfrom: document.getElementById("lat_from").value, 
                        latto: document.getElementById("lat_to").value,
                        lngfrom: document.getElementById("lng_from").value,
                        lngto: document.getElementById("lng_to").value,
                        populationfrom: document.getElementById("population_from").value,
                        populationto: document.getElementById("population_to").value,


                        },
                         success: function(cities){
              
    var crds=cities;
    document.getElementById("query_results_info").innerHTML='query returned '+ crds.length+' results.';
    if(crds.length){
      var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 4, center: {lat: parseFloat(crds[0]['lat']),lng: parseFloat(crds[0]['lng'])}}); 
    }
    else{
      var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 2, center}); 
    }
for(i in crds){
    marker= new google.maps.Marker({
            position: {lat: parseFloat(crds[i]['lat']),lng: parseFloat(crds[i]['lng'])},
            map: map,
            title: "collection" 
    });
    var infowindow=new google.maps.InfoWindow();
   google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(crds[i]['city']+'<div>'+crds[i]['population']+'<div>'+'lat:'+crds[i]['lat']+' '+'lng:'+crds[i]['lng']+'</div>'+'</div>'); // todo da nqma html v js !1!
          infowindow.open(map, marker);
        }
      })(marker, i));        }}})
   
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
