<?php

// Replace with your database credentials
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_dbname";

// Create database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start listening for incoming data streams
while (true) {
    $socket = stream_socket_server("tcp://0.0.0.0:12345", $errno, $errstr);

    if (!$socket) {
        echo "$errstr ($errno)\n";
    } else {
        // Accept incoming connections and spawn child processes to handle each one
        while ($conn = stream_socket_accept($socket)) {
            $pid = pcntl_fork();
            if ($pid == -1) {
                die('Fork failed');
            } else if ($pid) {
                // Parent process
                fclose($conn);
            } else {
                // Child process
                $data = fread($conn, 1024);
                // Parse data and store it in database
                parse_data($data, $conn);
                fclose($conn);
                exit();
            }
        }
        fclose($socket);
    }
}

// Function to parse incoming data and store it in database
function parse_data($data, $conn) {
    // Extract vehicle ID and GPS data from incoming data
    parse_str($data, $params);
    $vehicle_id = $params['vehicle_id'];
    $gps_data = $params['gps_data'];

    // Store data in database
    $sql = "INSERT INTO traffic_data (vehicle_id, gps_data) VALUES ('$vehicle_id', '$gps_data')";
    if (mysqli_query($GLOBALS['conn'], $sql)) {
        echo "Data stored successfully";
    } else {
        echo "Error storing data: " . mysqli_error($GLOBALS['conn']);
    }
}

?>
