<?php
$servername = "your_DB_SERVERNAME";
$username = "your_DB_USERNAME";
$password = "your_DB_PASSWORD";
$dbname = "your_DB_NAME";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];
$sql = "INSERT INTO gps_coordinates (latitude, longitude) VALUES ('$latitude', '$longitude')";
if ($conn->query($sql) === TRUE) {
  echo "GPS coordinates added successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
