<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
if (!isset($_GET["toAddress"])  || !isset($_GET["fromAddress"]) ) {
    
    header("Location: " .
     "../student/index.php");
    exit();
  }
  $toAddress = $_GET["toAddress"];
  $fromAddress = $_GET["fromAddress"];
  $isavailable= "";
  $busroute = [];
  if(date("l") == "Monday"){    
    $isavailable= 'is_avail_monday';    
  }
  else if(date("l") == "Tuesday"){
    $isavailable= 'is_avail_tuesday';    
  }
  else if(date("l") == "Wednesday"){
    $isavailable= 'is_avail_wednesday';    
  }
  else if(date("l") == "Thursday"){
    $isavailable= 'is_avail_thursday';    
  }
  else if(date("l") == "Friday"){
    $isavailable= 'is_avail_friday';    
  }
  else if(date("l") == "Saturday"){
    $isavailable= 'is_avail_saturday';    
  }
  else if(date("l") == "Sunday"){
    $isavailable= 'is_avail_monday';    
  }
  
require("../dbconnection.php");
    $connection = connect();
    
    if (mysqli_connect_errno())
    {         
         $output = array("message" =>  "Failed to connect to MySQL: " . mysqli_connect_error());
         echo json_encode($output);
      exit();
    }
    // echo $toAddress;
    // echo $fromAddress;
    $query =  "SELECT  *, STR_TO_DATE(time,'%h:%i %p') as Time from route where from_address='"
                . $fromAddress ."' and to_address= '". $toAddress ."'"." AND ".$isavailable."=1 and STR_TO_DATE(time,'%h:%i %p') > CURRENT_TIME() ORDER BY STR_TO_DATE(time,'%h:%i %p') Limit 1";
    
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
else{

    if($isavailable ='is_avail_monday'){
        $isavailable='is_avail_tuesday';
    }
    else if($isavailable='is_avail_tuesday'){
        $isavailable ='is_avail_wednesday';
    }
    else if($isavailable='is_avail_wednesday'){
        $isavailable ='is_avail_thursday';
    }
    else if($isavailable='is_avail_thursday'){
        $isavailable ='is_avail_friday';
    }
    else if($isavailable='is_avail_friday'){
        $isavailable ='is_avail_saturday';
    }
    else if($isavailable='is_avail_saturday'){
        $isavailable ='is_avail_monday';
    }
    $query =  "SELECT  *, STR_TO_DATE(time,'%h:%i %p') as Time from route where from_address='"
                . $fromAddress ."' and to_address= '". $toAddress ."'"." AND is_avail_monday=1 and STR_TO_DATE(time,'%h:%i %p') > CURRENT_TIME() ORDER BY STR_TO_DATE(time,'%h:%i %p') LIMIT 1";
    
    $results = mysqli_query($connection, $query);

    while ($e = mysqli_fetch_assoc($results)){
        $item = array(
        "route_id" => $e["route_id"],
        "time" => $e["time"],
        );
        array_push($busroute, $item);
     }
}
echo json_encode($busroute);

?>