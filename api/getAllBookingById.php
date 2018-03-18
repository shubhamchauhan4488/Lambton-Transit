<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
if (!isset($_GET["UserId"])) {
    
    header("Location: " . "../student/index.php");
    exit();
  }
  $UserId = $_GET["UserId"];
  
require("../dbconnection.php");
    $connection = connect();
    
    if (mysqli_connect_errno())
    {         
         $output = array("message" =>  "Failed to connect to MySQL: " . mysqli_connect_error());
         echo json_encode($output);
      exit();
    }    

    $query =  'Select bus.Id,bus.BookingDate, bus.SeatNo,bus.Price,route.time, route.from_address,route.to_address from bus_ticket bus LEFT JOIN route on route.route_id=bus.RouteId where bus.UserId='.$UserId.' ORDER BY BookingDate DESC, bus.Id DESC';

    $results = mysqli_query($connection, $query);

    if ($results == FALSE) {
      $output = array("message" =>   "Database query failed. ");
     echo json_encode($output);
      exit();
    }

    $busroute=[];
if(mysqli_num_rows($results) > 0){
    while ($e = mysqli_fetch_assoc($results)){
        $item = array(
        "BookingDate" => $e["BookingDate"],
        "SeatNo" => $e["SeatNo"],
        "Price" => number_format((float)$e["Price"], 2, '.', ''),
        "time" => $e["time"],
        "from_address" => $e["from_address"],
        "to_address" => $e["to_address"],
        "Id" => $e["Id"]
        );
        array_push($busroute, $item);
     }     
}

echo json_encode($busroute);

?>