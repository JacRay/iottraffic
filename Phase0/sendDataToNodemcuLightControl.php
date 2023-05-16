<?php

// Replace with the IP address of your NodeMCU and the port it is listening on
$ip = "192.168.1.10";
$port = 12346;

// Replace with the command you want to send to the NodeMCU
$command = "green";

// Establish TCP connection to NodeMCU
$socket = fsockopen($ip, $port, $errno, $errstr);

if (!$socket) {
    echo "$errstr ($errno)\n";
} else {
    // Send command to NodeMCU
    fwrite($socket, $command);

    // Wait for response from NodeMCU
    $response = fgets($socket);

    // Print response from NodeMCU
    echo "Response: $response";

    // Close TCP connection
    fclose($socket);
}

?>
