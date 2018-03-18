<?php
session_start();
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";
    $dbname = "transit";

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
    }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sql2 = "DELETE FROM validsessions WHERE tokenid = '" .$_COOKIE['tokenid'] . "'";
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
        $_SESSION["is_logIn"] = "false";
        setcookie("tokenid", "");
        setcookie("tokenusername", "");
        header("Location: " . "../log.php"); 
    }
  }

?>

<?php include 'master-page/left-panel.php' ?>
        <!-- Left Panel -->

<!-- /#left-panel -->


        <!-- Right Panel -->

        <div id="right-panel" class="right-panel">

<!-- Header-->
><!-- /header -->
<!-- Header-->



<div class="content mt-3">
    <div class="animated fadeIn">

        <div class="row">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-header"><strong>Logout</strong><small> Screen</small>
              </div>
              <div class="card-body card-block">
       

                <div class="col-md-6">
                <div class="card">
                <div class="card-header bg-dark">
                    <strong class="card-title text-light">Logout</strong>
                </div>
                <div class="card-body text-white bg-danger">
                    <p class="card-text text-light">Are you sure you want to logout?</p>
                    <form action = "logout.php" method = "POST">
                    <input type = "submit" value = "Yes">
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
