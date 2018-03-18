<?php include 'master-page/left-panel.php' ?>
<?php 
$source="";
$destination ="";
$bookingDate ="";
$time ="";
$seatNo="";
$ticketAmount ="";

if (!isset($_GET["id"])) {
    
    header("Location: " . "../student/view-all-tickcet.php");
    exit();
  }
  $Id = $_GET["id"];
  
require("../dbconnection.php");
    $connection = connect();
    
    if (mysqli_connect_errno())
    {         
         $output = array("message" =>  "Failed to connect to MySQL: " . mysqli_connect_error());
         echo json_encode($output);
      exit();
    }    

    $query =  'Select bus.Id,bus.BookingDate, bus.SeatNo,bus.Price,route.time, route.from_address,route.to_address from bus_ticket bus LEFT JOIN route on route.route_id=bus.RouteId where bus.Id='.$Id;

    $results = mysqli_query($connection, $query);

    if ($results == FALSE) {
      $output = array("message" =>   "Database query failed. ");
     echo json_encode($output);
      exit();
    }

    $busroute=[];
if(mysqli_num_rows($results) > 0){
    while ($e = mysqli_fetch_assoc($results)){
        
        $bookingDate  = $e["BookingDate"];
        $seatNo = $e["SeatNo"];
        $ticketAmount = number_format((float)$e["Price"], 2, '.', '');
        $time = $e["time"];
        $source = $e["from_address"];
        $destination = $e["to_address"];
        
        
     }     
}

?>
<div id="right-panel" class="right-panel">
<!-- .content -->
<div class="content mt-3">
    <div class="animated fadeIn">

        <div class="row">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-header"><strong>Ticket Details</strong></div>
              <div class="card-body card-block">
              <form  action = "confirm-booking.php" method="POST">
                                <div class="row" >
                                    <label for="source" class="control-label col-sm-2">Source:</label>                                                                        
                                    <span class="col-sm-10"><?php echo $source?></span>
                                </div>
                                <div class="row" >
                                    <label for="destination" class="col-sm-2">Destination:</label>                                    
                                    <span class="col-sm-10"><?php echo $destination?></span>
                                </div>
                                <div class="row" >
                                    <label for="bookingDate" class="col-sm-2">Booking Date:</label>                                    
                                    <span class="col-sm-10"><?php echo $bookingDate?></span>
                                </div>
                                <div class="row" >
                                    <label for="time" class="col-sm-2">Time:</label>                                    
                                    <span class="col-sm-10"><?php echo $time?></span>
                                </div>
                                <div class="row" >
                                    <label for="amount" class="col-sm-2">Amount:</label>                                   
                                    <span class="col-sm-10"><?php echo $ticketAmount?></span>
                                </div>
                                <div class="row" >
                                    <label for="time" class="col-sm-2">Seat Number:</label>                                    
                                    <span class="col-sm-10"><?php echo $seatNo?></span>
                                </div>                                                                
                                <div class="row" >
                                    <label for="amount" class="col-sm-2">Bar Code:</label>   
                                    <img alt="TESTING" src="barcode.php?size=20&text='<?php echo $seatNo?>'" />                                
                                    
                                </div>
                    

                </form>
            </div>
          </div>

          </div><!-- .animated -->
</div>

</div>
</body>
</html>