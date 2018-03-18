
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
    require("../dbconnection.php");
    $connection = connect();

    if (mysqli_connect_errno())
    {         
        $output = array("message" =>  "Failed to connect to MySQL: " . mysqli_connect_error());
        echo json_encode($output);
    exit();
    }
    $query="SELECT seat_availability, time FROM `route` WHERE route_id='". $_POST['radioTime'] ."'";    
    $results = mysqli_query($connection, $query);
    if(mysqli_num_rows($results) > 0){        
        $data = mysqli_fetch_assoc($results);
        $totalSeat = $data["seat_availability"];
        $time = $data["time"];
        $formatDate = strtotime($_POST['bookingDate']);
        $bookingDateFormat = date('Y-m-d',$formatDate);

        $query="SELECT count(Id) as BookedSeat FROM bus_ticket WHERE RouteId ='". $_POST['radioTime'] ."' and BookingDate = '" .$bookingDateFormat ."'";    
        $results = mysqli_query($connection, $query);
        $results = mysqli_query($connection, $query);
        if(mysqli_num_rows($results) > 0){    
            // echo  $query;   
            $data = mysqli_fetch_assoc($results);
            $totalBookedSeat = $data["BookedSeat"];
            $ticketAmount = 5;
            //$totalBookedSeat=4;
            if($totalSeat>$totalBookedSeat){
                if(!$totalSeat-$totalBookedSeat>5){
                    $ticketAmount += ( ($totalSeat-($totalSeat-$totalBookedSeat)) * 0.15);
                }
                session_start();
            
                $_SESSION['destination'] =$_POST['destination'];
                $_SESSION['source'] =$_POST['source'];
                $_SESSION['bookingDate'] =$bookingDateFormat;
                $_SESSION['routeId'] =$_POST['radioTime'];
                $_SESSION['time'] = $time;
                $_SESSION['ticketAmount'] = $ticketAmount;
                $_SESSION['ticketNo'] = $totalBookedSeat+1;            
                header("Location: " . "confirm-booking.php");
            }
            else{
                echo '<script language="javascript">';
                echo 'alert("No Seat Available.")';
                echo '</script>';
            }
            
        }


    }
    else{

    }
    

}    
?>
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
<?php include 'master-page/left-panel.php' ?>
<div id="right-panel" class="right-panel">
<div class="content mt-3">
    <div class="animated fadeIn">

        <div class="row">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-header"><strong>Book A Ticket</strong></div>
              <div class="card-body card-block">
                <form  action = "book-ticket.php" method="POST">
                                <div class="form-group" >
                                    <label for="source" class=" form-control-label">Source</label>
                                    <select class="form-control" id="source" name="source">
                                        <option value="Lambton">Lambton</option>
                                        <option value="Mississauga">Mississauga</option>
                                        <option value="Brampton">Brampton</option>
                                    </select>    
                                </div>
                                <div class="form-group">
                                    <label for="destination" class=" form-control-label">Destination</label>
                                    <select class="form-control" id="destination" name="destination">
                                        <option value="Lambton">Lambton</option>
                                        <option value="Mississauga">Mississauga</option>
                                        <option value="Brampton">Brampton</option>
                                    </select>  
                                </div>
                                <div class="form-group">
                                    <label for="Availability" class=" form-control-label">Date</label>
                                    <input type="text" id="bookingDate" class="form-control" name="bookingDate">
                                </div>

                                <div id="showBusTime" class="form-group">
                                    <label for="Availability" class=" form-control-label">Bus Timings</label>
                                    <span style="font-size: 12px;color: red;"> Rates are variable as per seat availability</span>
                                    <div id="busTiming">
                                        
                                    </div>
                                </div>
                    
                    
                    <div class = "row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <button id="showTimings"  class="btn btn-secondary mb-1">Show Timings</button>
                          <button id="bookTicket" type="submit"   class="btn btn-secondary mb-1 invisible">Book A Ticket</button>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
          </div>

          </div><!-- .animated -->
</div><!-- .content -->


</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
$( document ).ready(function() {
  $( function() {
    $( "#bookingDate" ).datepicker({
        minDate: new Date(),
        beforeShowDay: function(date) {
        var day = date.getDay();
        return [(day != 0), ''];
    }        
    }
    );
  } );
});
// function(event, ui) {
//     var date = $(this).datepicker('getDate');
//     var dayOfWeek = date.getUTCDay();
// };
//Show Bus Timings

$("#showTimings").on("click", function(e) {
    e.preventDefault();    
    var date = $("#bookingDate").datepicker('getDate');
    var currentDate = new Date(); 
    //Url Parameter declare
    var fromAddress, toAddress,bookingDay;
    var isCurrentBooking = 0;
    bookingDay=$.datepicker.formatDate('DD', date);
    if(date.toLocaleDateString('en-US') == currentDate.toLocaleDateString('en-US')){
        isCurrentBooking=1;
    }
    fromAddress = $("#source").val();
    toAddress = $("#destination").val();
    var urlAdd = "../api/getBusTimingByDate.php?toAddress="+toAddress+"&fromAddress="+fromAddress+"&bookingDay="+bookingDay+"&isCurrentBooking="+isCurrentBooking;
      
    $.ajax({type: "GET",
        url: urlAdd,        
        success:function(result) {
            if(result.length != 0){
                //BInd Radio Button
                var htmlGenerator = '';
                for (i = 0; i < result.length; i++) { 
                    htmlGenerator +='<label style="margin-right:10px" class="radio-inline"><input type="radio" name="radioTime" value="'+result[i].route_id+'">'+
                    result[i].time+
                    '</label>'
                }
                $("#busTiming").html(
                    htmlGenerator
                );
                $("#bookTicket").removeClass("invisible");
                $("#showTimings").css('display','none');  
            }
            else{
                $("#busTiming").html(
                    '<div class="alert alert-danger" role="alert">'+
                    'No Bus Available'+
                    '</div>'
                );
            }

        },
        error:function(result) {

            //Change Id for Error
            $("#busTiming").html(
                    '<div class="alert alert-danger" role="alert">'+
                    'Something went wrong. Please contact admin'+
                    '</div>'
                );
        }
    });

});

  </script>
</body>
</html>
 <?php 
}else{
  header("Location: " . "../log.php");
}
  ?>