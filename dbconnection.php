<?php 

	 
	 
	 
	 define("DBHost","localhost" );
	 	 define("DBUser","root" );
		 	 define("DBPass","root" );
			 	 define("DBName","transit" );
	 
	 
 function connect(){
	 
	  $connection = mysqli_connect(DBHost, DBUser, DBPass, DBName);

              if (mysqli_connect_errno())
              {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                exit();
              }
	 
	 return $connection;
	 
 }
 
  

?>