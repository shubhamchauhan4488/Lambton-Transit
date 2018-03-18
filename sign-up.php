<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {

// Get the form values that were sent by addEmployee.php
$newuser = [];
$newuser["nam"] = $_POST['name'];
$newuser["em"] = $_POST['email'];
$newuser["pass"] = $_POST['password'];

// @TODO: your database code should  here
//---------------------------------------------------
// Credentials
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "transit_database";

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
$sql = "INSERT INTO user";
$sql .= "(name,email,password)";
$sql .= "VALUES ";
$sql .= "(";
$sql .= "'" . $newuser["nam"] . "', ";
$sql .= "'" . $newuser["em"] . "', ";
$sql .= "'" . $newuser["pass"] . "'";
$sql .= ")";

$results = mysqli_query($connection, $sql);

if ($results == FALSE) {
    // there was an error in the sql 
    echo "Database query failed. <br/>";
    echo "SQL command: " . $sql;
    exit();
  }

// 4. Release returned data
//  mysqli_free_result($results);

// 5. Close database connection
mysqli_close($connection);
} 
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Material Design Login Form</title>
      <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <!--Google Font - Work Sans-->
<link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,700' rel='stylesheet' type='text/css'>
<div class="container">
  <div class="profile">
    <button class="profile__avatar" id="toggleProfile">
     <img src="TTC.png" alt="Avatar" /> 
    </button>
    <form action = "sign-up.php" method = "POST">
    <div class="profile__form">
      <div class="profile__fields">
      <div class="field">
          <input type="text" id="fieldUser" class="input" name = "name" required pattern=.*\S.* />
          <label for="fieldUser" class="label">Name</label>
        </div>
        <div class="field">
          <input type="text" id="fieldUser" class="input" name = "email" required pattern=.*\S.* />
          <label for="fieldUser" class="label">Email</label>
        </div>
        <div class="field">
          <input type="password" id="fieldPassword" class="input" name = "password" required pattern=.*\S.* />
          <label for="fieldPassword" class="label">Password</label>
        </div>
        <div class="profile__footer">
           <input class="button raised blue" type = "submit" value = "Sign Up">
        </div>
      </div>
       <a href="log.php">Back to Login</a>
    </div>
    </form>

     </div>
  </div>
</div>
  
  

    <script  src="js/index.js"></script>




</body>

</html>
