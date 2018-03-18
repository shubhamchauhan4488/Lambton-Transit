<?php
    require("../twilio-php-master/Twilio/autoload.php");
    use Twilio\Rest\Client;
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
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

      $sql 	 = "SELECT * FROM route ";
      $sql 	.= "WHERE route_id='" . $_GET['id'] . "'";

      $results = mysqli_query($connection, $sql);

      $from_address = "";
      $to_address = "";

      while ($data = mysqli_fetch_assoc($results)) {
        $from_address = $data['from_address'];
        $to_address = $data['to_address'];
      }

      $sql = "SELECT * FROM user";

      $results = mysqli_query($connection, $sql);

      $account_sid = 'AC1f70cfb991b87c000be5f21d19c2f990';
      $auth_token = '0542fb8108d66694893ac99d964417fc';

      // A Twilio number you own with SMS capabilities
      $twilio_number = "+16474924480";

      $client = new Client($account_sid, $auth_token);



      $array_phonenumbers = array();
      while ($user = mysqli_fetch_assoc($results)) {
        array_push($array_phonenumbers,$user['phone_number']);
        $client->messages->create(
          // Where to send a text message (your cell phone?)
          '+1'.$user['phone_number'],
          array(
              'from' => $twilio_number,
              'body' => 'Bus from '.$_POST['source']." to ".$_POST['destination']." is delayed by ".$_POST['minutes']." minutes."
          )
      );
     }

     
      mysqli_free_result($results);
      mysqli_close($connection);

}
else if($_SERVER['REQUEST_METHOD'] == 'GET') {

echo '<script language="javascript">alert("message is successfully sent")</script>';

  if (isset($_GET["id"]) == FALSE) {
    // missing an id parameters, so
    // redirect person back to add employee page
    header("Location: " . "index.html");
    exit();
  }

  $id = $_GET["id"];

  // @TODO: Your code should show the person's information in the form

  // @TODO: your database code should  here
  //---------------------------------------------------
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

  $sql 	 = "SELECT * FROM route ";
  $sql 	.= "WHERE route_id='" . $id . "'";

  $results = mysqli_query($connection, $sql);

  $from_address = "";
  $to_address = "";
  $time = "";

  while ($data = mysqli_fetch_assoc($results)) {
    $from_address = $data['from_address'];
    $to_address = $data['to_address'];
    $time = $data['time'];
  }

  $timearray = explode(":", $time);
  $hour = (int)$timearray[0];
  $array = str_split($timearray[1]);
  $minute = $array[0].$array[1];
  $ampm = $array[2].$array[3];

  if ($results == FALSE) {
    // there was an error in the sql
    echo "Database query failed. <br/>";
    echo "SQL command: " . $query;
    exit();
  }

  $routes = mysqli_fetch_assoc($results);
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
                        <form action = "<?php echo 'log.php'; ?>" method="POST" >
                            <div class="form-group"><label for="Source" class=" form-control-label">Source</label><input type="text" name="source"  value='<?php echo $from_address; ?>' disabled class="form-control"></div>
                            <div class="form-group"><label for="Destination" class=" form-control-label">Destination</label><input type="text" name="destination"  class="form-control" disabled value='<?php echo $to_address; ?>'></div>
                            <div class = "row">
                              <div class="col-lg-12">
                                <div class="form-group"><label for="Time" class=" form-control-label">Time</label>
                                  <select name="hours" disabled>
                                    <?php
                                      if ($hour == 1) {
                                        echo '<option value="01" selected>01</option>';
                                      } else {
                                        echo '<option value="01">01</option>';
                                      }
                                      if ($hour == 2) {
                                        echo '<option value="02" selected>02</option>';
                                      } else {
                                        echo '<option value="02">02</option>';
                                      }
                                      if ($hour == 3) {
                                        echo '<option value="03" selected>03</option>';
                                      } else {
                                        echo '<option value="03">03</option>';
                                      }
                                      if ($hour == 4) {
                                        echo '<option value="04" selected>04</option>';
                                      } else {
                                        echo '<option value="04">04</option>';
                                      }
                                      if ($hour == 5) {
                                        echo '<option value="05" selected>05</option>';
                                      } else {
                                        echo '<option value="05">05</option>';
                                      }
                                      if ($hour == 6) {
                                        echo '<option value="06" selected>06</option>';
                                      } else {
                                        echo '<option value="06">06</option>';
                                      }
                                      if ($hour == 7) {
                                        echo '<option value="07" selected>07</option>';
                                      } else {
                                        echo '<option value="07">07</option>';
                                      }
                                      if ($hour == 8) {
                                        echo '<option value="08" selected>08</option>';
                                      } else {
                                        echo '<option value="08">08</option>';
                                      }
                                      if ($hour == 9) {
                                        echo '<option value="09" selected>09</option>';
                                      } else {
                                        echo '<option value="09">09</option>';
                                      }
                                      if ($hour == 10) {
                                        echo '<option value="10" selected>10</option>';
                                      } else {
                                        echo '<option value="10">10</option>';
                                      }
                                      if ($hour == 11) {
                                        echo '<option value="11" selected>11</option>';
                                      } else {
                                        echo '<option value="11">11</option>';
                                      }
                                      if ($hour == 12) {
                                        echo '<option value="12" selected>12</option>';
                                      } else {
                                        echo '<option value="12">12</option>';
                                      }
                                    echo '</select>';
                                    echo '<select name="minutes" disabled>';
                                    if ($minute == 0) {
                                      echo '<option value="0" selected>00</option>';
                                    } else {
                                      echo '<option value="0">00</option>';
                                    }
                                    if ($minute == 5) {
                                      echo '<option value="5" selected>05</option>';
                                    } else {
                                      echo '<option value="5">05</option>';
                                    }
                                    if ($minute == 10) {
                                      echo '<option value="10" selected>10</option>';
                                    } else {
                                      echo '<option value="10">10</option>';
                                    }
                                    if ($minute == 15) {
                                      echo '<option value="15" selected>15</option>';
                                    } else {
                                      echo '<option value="15">15</option>';
                                    }
                                    if ($minute == 20) {
                                      echo '<option value="20" selected>20</option>';
                                    } else {
                                      echo '<option value="20">20</option>';
                                    }
                                    if ($minute == 25) {
                                      echo '<option value="25" selected>25</option>';
                                    } else {
                                      echo '<option value="25">25</option>';
                                    }
                                    if ($minute == 30) {
                                      echo '<option value="30" selected>30</option>';
                                    } else {
                                      echo '<option value="30">30</option>';
                                    }
                                    if ($minute == 35) {
                                      echo '<option value="35" selected>35</option>';
                                    } else {
                                      echo '<option value="35">35</option>';
                                    }
                                    if ($minute == 40) {
                                      echo '<option value="40" selected>40</option>';
                                    } else {
                                      echo '<option value="40">40</option>';
                                    }
                                    if ($minute == 45) {
                                      echo '<option value="45" selected>45</option>';
                                    } else {
                                      echo '<option value="45">45</option>';
                                    }
                                    if ($minute == 50) {
                                      echo '<option value="50" selected>50</option>';
                                    } else {
                                      echo '<option value="50">50</option>';
                                    }
                                    if ($minute == 55) {
                                      echo '<option value="55" selected>55</option>';
                                    } else {
                                      echo '<option value="55">55</option>';
                                    }
                                    if ($minute == 60) {
                                      echo '<option value="60" selected>60</option>';
                                    } else {
                                      echo '<option value="60">60</option>';
                                    }
                                    echo '</select>';
                                    echo '<select name="ampm" disabled>';
                                    if ($ampm == "AM") {
                                      echo '<option value="AM" selected>AM</option>';
                                    } else {
                                      echo '<option value="AM">AM</option>';
                                    }
                                    if ($ampm == "PM") {
                                      echo '<option value="PM" selected>PM</option>';
                                    } else {
                                      echo '<option value="PM">PM</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                              </div>
                            </div>
                            <div class = "row">
                              <div class="col-lg-12">
                                <div class="form-group"><label for="Time" class=" form-control-label">Delay Time</label>
                                    <select name="minutes">
                                      <option value="0">00</option>
                                      <option value="05">05</option>
                                      <option value="10" selected>10</option>
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
                                    Minutes
                                </div>
                              </div>
                            </div>

                            <div class = "row">
                              <div class="col-lg-6">
                                <div class="form-group">
                                  <button type="submit" class="btn btn-secondary mb-1">SEND DELAY NOTIFACTION</button>
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
