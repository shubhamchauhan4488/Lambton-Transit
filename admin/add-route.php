<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {

// Get the form values that were sent by addEmployee.php
$newroute = [];
$newroute["source"] = $_POST['source'];
$newroute["destination"] = $_POST['destination'];
$newroute["hours"] = $_POST['hours'];
$newroute["minutes"] = $_POST['minutes'];
$newroute["ampm"] = $_POST['ampm'];

$monday = 0;
$tuesday = 0;
$wednesday = 0;
$thursday = 0;
$friday = 0;
$saturday = 0;
if (!isset($_POST['monday'])) {
  $monday = 1;
}
if (!isset($_POST['tuesday'])) {
  $tuesday = 1;
}
if (!isset($_POST['wednesday'])) {
  $wednesday = 1;
}
if (!isset($_POST['thursday'])) {
  $thursday = 1;
}
if (!isset($_POST['friday'])) {
  $friday = 1;
}
if (!isset($_POST['saturday'])) {
  $saturday = 1;
}

$time = $newroute['hours'] . ":" . $newroute['minutes'] . $newroute['ampm'];

// @TODO: your database code should  here
//---------------------------------------------------
// Credentials
require("../dbconnection.php");
$connection = connect();

//INSERT INTO `route` (`route_id`, `from_address`, `to_address`, `time`, `is_avail_monday`, `is_avail_tuesday`, `is_avail_wednesday`, `is_avail_thursday`, `is_avail_friday`, `is_avail_saturday`) VALUES ('17', 'Lambton', 'Brampton', '12:30PM', '1', '1', '1', '1', '1', '1');

// 2. Perform database query (INSERT DATA IN TABLE)
$sql = "INSERT INTO route";
$sql .= "(from_address,to_address,time,is_avail_monday,is_avail_tuesday,is_avail_wednesday,is_avail_thursday,is_avail_friday,is_avail_saturday)";
$sql .= "VALUES ";
$sql .= "(";
$sql .= "'" . $newroute["source"] . "', ";
$sql .= "'" . $newroute["destination"] . "', ";
$sql .= "'" . $time . "', ";
$sql .= "'" . $monday . "', ";
$sql .= "'" . $tuesday . "', ";
$sql .= "'" . $wednesday . "', ";
$sql .= "'" . $thursday . "', ";
$sql .= "'" . $friday . "', ";
$sql .= "'" . $saturday . "'";
$sql .= ")";

$results = mysqli_query($connection, $sql);

if ($results == FALSE) {
    // there was an error in the sql
    echo "Database query failed. <br/>";
    echo "SQL command: " . $sql;
    exit();
  }else{
      // 5. Close database connection
      mysqli_close($connection);
      header("Location: " . "index.php");
  }

// 4. Release returned data
  mysqli_free_result($results);

// 5. Close database connection
 mysqli_close($connection);
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

<?php include 'master-page/left-panel.php' ?><!-- /#left-panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">



        <div class="content mt-3">
            <div class="animated fadeIn">

                <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header"><strong>New Route</strong></div>
                      <div class="card-body card-block">
                        <form action = "add-route.php" method="POST" >
                            <div class="form-group"><label for="Source" class=" form-control-label">Source</label><input type="text" name="source"  class="form-control"></div>
                            <div class="form-group"><label for="Destination" class=" form-control-label">Destination</label><input type="text" name="destination"  class="form-control"></div>
                            <div class = "row">
                              <div class="col-lg-12">
                                <div class="form-group"><label for="Time" class=" form-control-label">Time</label>
                                    <select name="hours">
                                      <option value="1">01</option>
                                      <option value="2">02</option>
                                      <option value="3">03</option>
                                      <option value="4">04</option>
                                      <option value="5">05</option>
                                      <option value="6">06</option>
                                      <option value="7">07</option>
                                      <option value="8">08</option>
                                      <option value="9">09</option>
                                      <option value="10">10</option>
                                      <option value="11">11</option>
                                      <option value="12">12</option>
                                    </select>
                                    <select name="minutes">
                                      <option value="0">00</option>
                                      <option value="05">05</option>
                                      <option value="10">10</option>
                                      <option value="15">15</option>
                                      <option value="20">20</option>
                                      <option value="25">25</option>
                                      <option value="30">30</option>
                                      <option value="35">35</option>
                                      <option value="40">40</option>
                                      <option value="45">45</option>
                                      <option value="50">50</option>
                                      <option value="55">55</option>
                                      <option value="60">60</option>
                                    </select>
                                    <select name="ampm">
                                      <option value="AM">AM</option>
                                      <option value="PM">PM</option>
                                    </select>
                                </div>
                              </div>
                            </div>
                            <div class = "row">
                              <div class="col-lg-6">
                                <div class="form-group"><label for="Availability" class=" form-control-label">Availability</label><br>
                                  <input type="checkbox" name="monday" value=0> Monday<br>
                                  <input type="checkbox" name="tuesday" value=0> Tuesday<br>
                                  <input type="checkbox" name="wednesday" value='0'> Wednesday<br>
                                  <input type="checkbox" name="thursday" value='0'> Thursday<br>
                                  <input type="checkbox" name="friday" value='0'> Friday<br>
                                  <input type="checkbox" name="saturday" value='0'> Saturday<br>
                                </div>
                              </div>
                            </div>
                            <div class = "row">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <button type="submit" class="btn btn-secondary mb-1">Add Route</button>
                                </div>
                              </div>
                            </div>
                        </form>
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

  </body>
</html>
 <?php 
}else{
  header("Location: " . "../log.php");
}
  ?>

