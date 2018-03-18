<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require("../dbconnection.php");
    $connection = connect();

    if (mysqli_connect_errno())
    {
         
         $output = array("message" =>  "Failed to connect to MySQL: " . mysqli_connect_error());
        echo json_encode($output);

      exit();
    }

    $query = "SELECT * FROM route";    
    $results = mysqli_query($connection, $query);

    if ($results == FALSE) {
      $output = array("message" =>   "Database query failed. ");
     echo json_encode($output);
      exit();
    }

$busroute = [];

while ($e = mysqli_fetch_assoc($results)){
   $item = array(
   "route_id" => $e["route_id"],   
   "time" => $e["time"],
   "is_avail_monday" => $e["is_avail_monday"],
   "is_avail_tuesday" => $e["is_avail_tuesday"],
   "is_avail_wednesday" => $e["is_avail_wednesday"],
   "is_avail_thursday" => $e["is_avail_thursday"],
   "is_avail_friday" => $e["is_avail_friday"],
   "is_avail_saturday" => $e["is_avail_saturday"],
   "from_address" => $e["from_address"],
   "to_address" => $e["to_address"]
   );
   array_push($busroute, $item);
}

echo json_encode($busroute);


?>