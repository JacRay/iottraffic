<?php

// Set the UDP port parameters
$udp_port = 12345; // Replace with the UDP port number of your NodeMCU

// Create a UDP socket and bind it to the port
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($socket, '0.0.0.0', $udp_port);

// Read the GPS data from the UDP socket
while (true) {
    $data = socket_recvfrom($socket, $buf, 1024, 0, $remote_ip, $remote_port);
    if ($data !== false) {
        // Parse the GPS data and extract the latitude and longitude
        $fields = explode(",", $buf);
        if (count($fields) >= 3 && $fields[0] == "$GPGGA") {
            $latitude = substr($fields[2], 0, 2) + (substr($fields[2], 2) / 60);
            $longitude = substr($fields[4], 0, 3) + (substr($fields[4], 3) / 60);
            $latitude_direction = $fields[3];
            $longitude_direction = $fields[5];
            if ($latitude_direction == "S") {
                $latitude = -$latitude;
            }
            if ($longitude_direction == "W") {
                $longitude = -$longitude;
            }
            // Print the latitude and longitude as a JSON string
            header('Content-Type: application/json');
            echo json_encode(array('latitude' => $latitude, 'longitude' => $longitude));
            break;
        }
    }
}

// Close the UDP socket
socket_close($socket);

?>
