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
    echo "erro";
    // header("Location: " . "../log.php");
    exit();
  }
  
?>
<?php
  if (isset($_GET["id"]) == FALSE) {
    // missing an id parameters, so
    // redirect person back to add employee page
    header("Location: " . "index.php");
    exit();
  }

  // save the ID so you can use it later
  $id = $_GET["id"];

  // @TODO: your database code should  here
    //---------------------------------------------------
    // require("../dbconnection.php");
    // $connection = mysqli_connect('localhost','root','root','transit');
    $connection = connect();

    $sql 	 = "SELECT * FROM route WHERE route_id='" . $id . "'";

    $results = mysqli_query($connection, $sql);
          
    if ($results == FALSE) {
      // there was an error in the sql 
      echo "Database query failed. <br/>";
      echo "SQL command: " . $sql;
      exit();
    }

    $routes = mysqli_fetch_assoc($results);


  // check for a POST request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sql2 = "DELETE FROM route WHERE route_id = '" .$id . "'";
    $results2 = mysqli_query($connection, $sql2);
    //---------------------------------------------------
    if ($results2 == FALSE) {
      // there was an error in the sql 
      echo "Database query failed. <br/>";
      echo "SQL command: " . $sql2;
      exit();
    }else{
        // 5. Close database connection
        mysqli_close($connection);
        echo "SQL command: " . $sql2;
        header("Location: " . "index.php"); 
    }
  }

?>

<?php include 'master-page/left-panel.php' ?>
        <!-- Left Panel -->

<!-- /#left-panel -->


        <!-- Right Panel -->

        <div id="right-panel" class="right-panel">

<!-- Header-->
<!-- /header -->
<!-- Header-->



<div class="content mt-3">
    <div class="animated fadeIn">

        <div class="row">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-header"><strong>Delete </strong><small></small>
              </div>
              <div class="card-body card-block">
              

                <div class="col-md-12">
                <div class="card">
                <div class="card-header bg-dark">
                    <strong class="card-title text-light">Confirm Delete</strong>
                </div>
                <div class="card-body text-white bg-danger">
                <p class="text-light">
                          Route ID : <?php echo $routes["route_id"] ?> <br>
                          Source : <?php echo $routes["from_address"] ?> <br>
                          Destination : <?php echo $routes["to_address"] ?> <br>
                          Time : <?php echo $routes["time"] ?> 
                    </p>
                    <p class="card-text text-light">This delete is irreversible. Click on button below to proceed</p>
                    <form action = "<?php echo "delete-route.php?id=" . $id; ?>" method = "POST">
                    <input type = "submit" value = "Yes" style = "color:black;">
                    </form> 
                </div>
                </div>
                </div>
            </div>
            </div>
            <div>

            
         
                
            </div>
          </div>

          </div><!-- .animated -->
</div><!-- .content -->


</div><!-- /#right-panel -->

<!-- Right Panel -->

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
    
  </body>
</html>
 <?php 
}else{
  header("Location: " . "../log.php");
}
  ?>
