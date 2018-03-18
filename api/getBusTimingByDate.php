<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
if (!isset($_GET["toAddress"])  || !isset($_GET["fromAddress"]) || !isset($_GET["bookingDay"]) ) {
    
    header("Location: " . "../student/index.php");
    exit();
  }
  $toAddress = $_GET["toAddress"];
  $fromAddress = $_GET["fromAddress"];
  $bookingDay = $_GET["bookingDay"];
  $isCurrentBooking = FALSE;
  if($_GET["isCurrentBooking"] == 1){
    $isCurrentBooking = TRUE;
  }
  
  

  $isavailable= "";
  $busroute = [];
  if($bookingDay == "Monday"){    
    $isavailable= 'is_avail_monday';    
  }
  else if($bookingDay == "Tuesday"){
    $isavailable= 'is_avail_tuesday';    
  }
  else if($bookingDay == "Wednesday"){
    $isavailable= 'is_avail_wednesday';    
  }
  else if($bookingDay == "Thursday"){
    $isavailable= 'is_avail_thursday';    
  }
  else if($bookingDay == "Friday"){
    $isavailable= 'is_avail_friday';    
  }
  else if($bookingDay == "Saturday"){
    $isavailable= 'is_avail_saturday';    
  }
  
  
require("../dbconnection.php");
    $connection = connect();
    
    if (mysqli_connect_errno())
    {         
         $output = array("message" =>  "Failed to connect to MySQL: " . mysqli_connect_error());
         echo json_encode($output);
      exit();
    }
    if($isCurrentBooking){
        $query =  "SELECT  *, STR_TO_DATE(time,'%h:%i %p') as Time from route where from_address='"
                . $fromAddress ."' and to_address= '". $toAddress ."'"." AND ".$isavailable."=1 and STR_TO_DATE(time,'%h:%i %p') > CURRENT_TIME()";
    }
    else{
        $query =  "SELECT  *, STR_TO_DATE(time,'%h:%i %p') as Time from route where from_address='"
                . $fromAddress ."' and to_address= '". $toAddress ."'"." AND ".$isavailable."=1";
    }
    
    $results = mysqli_query($connection, $query);

    if ($results == FALSE) {
      $output = array("message" =>   "Database query failed. ");
     echo json_encode($output);
      exit();
    }


if(mysqli_num_rows($results) > 0){
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
}

echo json_encode($busroute);

?>