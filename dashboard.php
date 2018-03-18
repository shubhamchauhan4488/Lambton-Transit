<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {

// Get the form values that were sent by addEmployee.php
$email = $_POST["email"];
$pass = $_POST["password"];
echo "hey we are at the 2nd page" ;
// @TODO: your database code should  here
//---------------------------------------------------
// Credentials
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "college_ttc";

// 1. Create a database connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// show an error message if PHP cannot connect to the database
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 exit();
}


//INSERT INTO `employees` (`id`, `first_name`, `last_name`, `hire_date`) VALUES ('2', 'sss', 'www', '2017-08-07');
// 2. Perform database query (INSERT DATA IN TABLE)
$sql = "SELECT * FROM route";


echo $sql . "<br/>";

$results = mysqli_query($connection, $sql);

if ($results == TRUE) {
 echo "<h1> Succeess! </h1>";
}
else {
 echo "Database query failed. <br/>";
 echo "SQL command: " . $query;
 exit();
}

// // 4. Release returned data
// //  mysqli_free_result($results);

// // 5. Close database connection
// mysqli_close($connection);

// //---------------------------------------------------

// // @TODO: delete these two statement after your add your db code
// echo "I got a POST request! <br />";
// print_r($_POST);


// } else {

// // you got a GET request, so
// // redirect person back to add employee page
// header("Location: " . "login2.php");
// exit();
// }
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/spectre.min.css">
    <link rel="stylesheet" href="css/spectre-exp.min.css">
    <link rel="stylesheet" href="css/spectre-icons.min.css">
  </head>
  <body>
    <header>
      <h1> Dashboard </h1>
    </header>
  

    <div class="container">
      <div class = "columns">
        <div class="column col-10 col-mx-auto">

          <table class="table">
            <tr>
              <th>ID</th>
              <th>Route No</th>
              <th>Bus no</th>
              <th>Destination</th>
              <th>Departure Time</th>
            </tr>

            <!-- we got a results from the database, so put them into the table -->
            <?php while ($route = mysqli_fetch_assoc($results)) { ?>
              <tr>
                <td><?php echo $route['id']; ?></td>
                <td><?php echo $route['routeNumber']; ?></td>
                <td><?php echo $route['busNumber']; ?></td>
                <td><?php echo $route['destination']; ?></td>
                <td><?php echo $route['departTime']; ?></td>
              </tr>
            <?php } ?>

          </table>


        </div> <!--// col-12 -->
      </div> <!-- // column -->
    </div> <!--// container -->

    <footer>
      &copy; <?php echo date("Y") ?> Cestar College
    </footer>

    <?php
      // clean up and close database
      mysqli_free_result($results);
      mysqli_close($connection);
    ?>

  </body>
</html>

