<?php
// Define the database credentials
$databaseHost = "YOUR_DATABASE_HOST";
$databaseUsername = "YOUR_DATABASE_USERNAME";
$databasePassword = "YOUR_DATABASE_PASSWORD";
$databaseName = "YOUR_DATABASE_NAME";

// Create a new MySQL connection
$database = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName);

// Check if the connection was successful
if ($database->connect_errno) {
    die("Failed to connect to MySQL: " . $database->connect_error);
}

// Check if the latitude and longitude were sent
if (isset($_POST["latitude"]) && isset($_POST["longitude"])) {
    // Sanitize the latitude and longitude values
    $latitude = $database->real_escape_string($_POST["latitude"]);
    $longitude = $database->real_escape_string($_POST["longitude"]);

    // Insert the latitude and longitude into the database
    $query = "INSERT INTO locations (latitude, longitude) VALUES ('$latitude', '$longitude')";
    if (!$database->query($query)) {
        echo "Error: " . $query . "<br>" . $database->error;
    }
}

// Close the database connection
$database->close();
?>
