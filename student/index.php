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
        

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <!-- /header -->
        <!-- Header-->

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">All Routes</strong>
                        </div>
                        <div class="card-body">
                            <div id="nextBusError"></div>
                            <table class="table">
                              <thead class="thead-dark">
                                <tr>
                                  <th scope="col">Route Id</th>
                                  <th scope="col">Source</th>
                                  <th scope="col">Destination</th>
                                  <th scope="col">Time</th>
                                  <th scope="col">Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                
                                
                              </tbody>
                            </table>
                             
                        </div>
                    </div>
                </div>



                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->


    <script src="../assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/main.js"></script>

<script>
    $( document ).ready(function() {
        console.log( "ready!" );
        var urlAdd = "../api/get-all-bus.php";
        $.ajax({type: "GET",
        url: urlAdd,        
        success:function(result) {
            if(result.length !=0){
                console.log(result);
                for (i = 0; i < result.length; i++) { 
                $("tbody").append('<tr class="btnDelete" data-id="2"><th scope="row">'+
                result[i].route_id +'</th>'+
                                  '<td>'+result[i].from_address+'</td>'+
                                  '<td>'+result[i].to_address+'</td>'+
                                  '<td>'+result[i].time+'</td>'+
                                  '<td>'+'<a target="_blank"  href = "showrouteonmap.php?id='+result[i].route_id+'">Google Map</a> </td>' +
                                   '</tr>');       
                }
            }
            

        },
        error:function(result) {
            $("#nextBusError").html(
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

