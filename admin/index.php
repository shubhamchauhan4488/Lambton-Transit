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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Routes</strong>
                        </div>
                        <div class="card-body">
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
                                <?php

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

                                $sql = "SELECT * FROM route";

                                $results = mysqli_query($connection, $sql);

                                while ($route = mysqli_fetch_assoc($results)) { ?>
                                <tr class="btnDelete" data-id="2">
                                  <th scope="row"><?php echo $route['route_id']; ?></th>
                                  <td><?php echo $route['from_address']; ?></td>
                                  <td><?php echo $route['to_address']; ?></td>
                                  <td><?php  echo $route['time']; ?></td>
                                  <td><a href = "<?php echo 'edit-route.php?id=' . $route['route_id']; ?>">Edit</a> <a href="<?php echo 'delete-route.php?id=' . $route['route_id']; ?>">Delete</a>
                                  <?php } ?>
                                </tr>
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

    <?php
    // clean up and close database
    mysqli_free_result($results);
    mysqli_close($connection);
  ?>
</body>
</html>
 <?php 
}else{
  header("Location: " . "../log.php");
}
  ?>

