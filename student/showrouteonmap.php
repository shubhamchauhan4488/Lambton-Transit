<?php if(isset($_COOKIE['tokenid'])) 
 { 
  $tokenID = $_COOKIE['tokenid'];

  require("../dbconnection.php");
  $connection = connect();
  
  $sql2  = "SELECT * FROM validsessions where tokenid =" . $tokenID;

  $results2 = mysqli_query($connection, $sql2);     
  $correctuser = mysqli_fetch_assoc($results2);
  if ($results2 == FALSE ||  $correctuser['username'] != $_COOKIE['tokenusername']) {
    // there was an error in the sql 
    header("Location: " . "../log.php");
    exit();
  }
  
?>
<?php
  if($_SERVER['REQUEST_METHOD'] == 'GET') {

    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";
    $dbname = "transit";

    // 1. Create a database connection
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // show an error message if PHP cannot connect to the database
    if (mysqli_connect_errno())
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();
    }

    $sql = "SELECT * FROM route where route_id=".$_GET['id'];

    $results = mysqli_query($connection, $sql);

    $source = "";
    $destination = "";
    while ($route = mysqli_fetch_assoc($results)) {
      $source = $route['from_address'];
      $destination = $route['to_address'];
     }
     mysqli_free_result($results);
     mysqli_close($connection);

     if ($source == "Lambton") {
       $source = "265 Yorkland Blvd, North York, ON M2J 1S5";
     }
     else if ($source == "Brampton") {
       $source = "Brampton, ON";
     }
     else {
       $source = "Mississauga, ON";
     }

     if ($destination == "Lambton") {
       $destination = "265 Yorkland Blvd, North York, ON M2J 1S5";
     }
     else if ($destination == "Brampton") {
       $destination = "Brampton, ON";
     }
     else {
       $destination = "Mississauga, ON";
     }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions service</title>
    <style>
      #map {
        height: 100%;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: 43.7108659, lng: -79.7327018}
        });
        directionsDisplay.setMap(map);

        var onChangeHandler = function() {
          calculateAndDisplayRoute(directionsService, directionsDisplay);
        };

        directionsService.route({
            origin: "<?php echo $source; ?> ",
            destination: "<?php echo $destination; ?>",
            travelMode: 'DRIVING'
          }, function(response, status) {
              if (status === 'OK') {
                  directionsDisplay.setDirections(response);
              } else {
                window.alert('Directions request failed due to ' + status);
              }
          });
    }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzLpXRUm-m3LyMaRO_BMWtriky8HgLATc&callback=initMap">
    </script>
  </body>
</html>
 <?php 
}else{
  header("Location: " . "../log.php");
}
  ?>

