<?php
	 $host = "localhost";
	 $user = "root";
	 $pass = "";
	 $db = "N&N_Cafe";
	 mysqli_set_charset($conn,"utf8");

	 $conn = new mysqli($host, $user, $pass, $db);
	 if($conn->connect_error){
	 	die('Connection Failed: ' . $conn->connect_error );
	 } 
?>