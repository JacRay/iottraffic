<!DOCTYPE html>
<html>
  <head>
    <title>GPS Coordinates</title>
    <style>
      /* Set the height of the map */
      #map {
        height: 400px;
      }
    </style>
  </head>
  <body>
    <h1>GPS Coordinates</h1>
    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
    <script>
      // Define the coordinates array
      var coordinates = [];

      <?php
        // Connect to the database
        $servername = "your_DB_SERVERNAME";
        $username = "your_DB_USERNAME";
        $password = "your_DB_PASSWORD";
        $dbname = "your_DB_NAME";
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Get the coordinates from the database
        $sql = "SELECT latitude, longitude FROM gps_coordinates";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
          $latitude = $row["latitude"];
          $longitude = $row["longitude"];
          echo "coordinates.push({ lat: $latitude, lng: $longitude });\n";
        }

        $conn->close();
      ?>

      // Initialize the map
      function initMap() {
        var map = new google.maps.Map(document.getElementById("map"), {
          zoom: 10,
          center: coordinates[0]
        });

        // Add markers for each coordinate
        for (var i = 0; i < coordinates.length; i++) {
          var marker = new google.maps.Marker({
            position: coordinates[i],
            map: map
          });
        }
      }
    </script>
    <script async defer onload="initMap()" src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
  </body>
</html>
