<?php
$hostname = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "iot"; 

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) { 
	die("Connection failed: " . mysqli_connect_error()); 
} 

echo "Database connection is OK<br>"; 

if(isset($_POST["ve"]) && isset($_POST["lat"]) && isset($_POST["lon"])) {

	$v = $_POST["ve"];
	$lat = $_POST["lat"];
	$lon = $_POST["lon"];
	// '?' for string, ".?." for float and int 
	$sql = "INSERT INTO `traffic_data`(`vehicle_id`, `lat`, `lon`) VALUES ('$v',".$lat.",".$lon.")"; 

	if (mysqli_query($conn, $sql)) { 
		echo "\nNew record created successfully"; 
	} else { 
		echo "Error: " . $sql . "<br>" . mysqli_error($conn); 
	}
}

?>