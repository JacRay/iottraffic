<?php

// Check if data was received via POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract vehicle ID and GPS data from POST request
    $vehicle_id = $_POST['vehicle_id'];
    $gps_data = $_POST['gps_data'];

    // Display data in browser
    echo "<p>Vehicle ID: " . $vehicle_id . "</p>";
    echo "<p>GPS Data: " . $gps_data . "</p>";
}

?>
