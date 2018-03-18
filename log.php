<?php
session_start();
if($_SESSION["is_logIn"] == "true"){
  if($_COOKIE['tokenusername'] == "ash@gmail.com"){
    header("Location: " . "admin/index.php");
  }else{
    header("Location: " . "student/index.php"); 
  }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

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

$sql 	 = "SELECT * FROM user ";

$results = mysqli_query($connection, $sql);
      
if ($results == FALSE) {
  // there was an error in the sql 
  echo "Database query failed. <br/>";
  echo "SQL command: " . $sql;
  exit();
}
while ($user = mysqli_fetch_assoc($results)) { 
    if ($user['email']==$_POST['email'] && $user['password']==$_POST['password']){
      if($_POST['email'] == "ash@gmail.com" && $_POST['password'] == "admin"){

        //Creating a sessions variable
        $_SESSION["is_logIn"] = "true";

        //generating unique id
        $tokenId = rand(1000000,9999999);
        $tokenUserName = $user['email'];

        //Storing the user, tokenid in database
        $sql2 = "INSERT INTO validsessions";
        $sql2 .= "(username,tokenid)";
        $sql2 .= "VALUES ";
        $sql2 .= "(";
        $sql2 .= "'" . $tokenUserName . "', ";
        $sql2 .= "'" . $tokenId . "'";
        $sql2 .= ")";

        $results2 = mysqli_query($connection, $sql2);
      
        if ($results2 == FALSE) {
          // there was an error in the sql 
          echo "Database query failed. <br/>";
          echo "SQL command: " . $sql2;
          exit();
        }

        //Setting a cookie
        setcookie("tokenid", $tokenId);
        setcookie("tokenusername", $tokenUserName);

        // $user['is_already_login'] = 1;
        header("Location: " . "admin/index.php");
        exit();

      }
         //Creating a sessions variable
         $_SESSION["is_logIn"] = "true";

         //generating unique id
         $tokenId = rand(1000000,9999999);
         $tokenUserName = $user['email'];
 
         //Storing the user, tokenid in database
         $sql2 = "INSERT INTO validsessions";
         $sql2 .= "(username,tokenid)";
         $sql2 .= "VALUES ";
         $sql2 .= "(";
         $sql2 .= "'" . $tokenUserName . "', ";
         $sql2 .= "'" . $tokenId . "'";
         $sql2 .= ")";
 
         $results2 = mysqli_query($connection, $sql2);
       
         if ($results2 == FALSE) {
           // there was an error in the sql 
           echo "Database query failed. <br/>";
           echo "SQL command: " . $sql2;
           exit();
         }
 
         //Setting a cookie
         setcookie("tokenid", $tokenId);
         setcookie("tokenusername", $tokenUserName);
        // $user['is_already_login'] = 1;
        header("Location: " . "student/index.php"); 
        exit();
    }else{
      echo "Failure" ;
    }
}
}

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/style2.css">
  <style>
  #sign-up{display: none;}
  </style>
</head>

<body>

  <!--Google Font - Work Sans-->
<link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,700' rel='stylesheet' type='text/css'>
<div class="container">
  <div class="profile">
    <button class="profile__avatar" id="toggleProfile">
     <img src="LT.png" alt="Avatar" /> 
    </button>
    <form action = "log.php" method = "POST"  id="login">
    <div class="profile__form">
      <div class="profile__fields">
        <div class="field">
          <input type="text" id="fieldUser" class="input" name = "email" required pattern=.*\S.* />
          <label for="fieldUser" class="label">Username</label>
        </div>
        <div class="field">
          <input type="password" id="fieldPassword" class="input" name = "password" required pattern=.*\S.* />
          <label for="fieldPassword" class="label">Password</label>
        </div>
        <div class="profile__footer">
           <input class="button raised blue" type = "submit" value = "LOGIN">
        </div>
    </form>

    <!-- <form action = "sign-up.php" method = "POST" id="sign-up">
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
           <input class="button raised blue" type = "submit" value = "Sign Up" onclick="bringSignUp()">
        </div>
      </div class="profile__footer">
       <a href="log.php">Back to Login</a>
      </div>
    </form> -->

     </div>
  </div>
</div>
  
    <script  src="js/index.js"></script>
    <!-- <script  type="text/javascript">
    function bringSignUp(){
    document.getElementById("sign-up").style.display = "block";
    document.getElementById("login").style.display = "none";
    }
    </script> -->



</body>

</html>
