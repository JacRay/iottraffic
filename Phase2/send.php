<!DOCTYPE html>
<html>
<head>
  <title>Button Calculation</title>
  <style>
     body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    h1 {
      color: #333;
    }
    form {
      margin-top: 20px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #666;
    }
    input[type="text"] {
      padding: 8px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      width: 200px;
    }
    input[type="submit"] {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color: #45a049;
    }
    p {
      margin-top: 20px;
      font-size: 16px;
      color: #333;
    }
  </style>
</head>
<body>
  <h1>Button Calculation</h1>
  
  <?php
  // Function to perform the calculation
  
  function performCalculation($point, $polygon) {
    $x = $point[0];
    $y = $point[1];

    $vertices = count($polygon);
    $intersections = 0;

    for ($i = 0, $j = $vertices - 1; $i < $vertices; $j = $i++) {
        $xi = $polygon[$i][0];
        $yi = $polygon[$i][1];
        $xj = $polygon[$j][0];
        $yj = $polygon[$j][1];

        if (($yi > $y) !== ($yj > $y) &&
            ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi)) {
            $intersections++;
        }
    }

    return $intersections % 2 !== 0;
}
 
  // Check if the form is submitted
  if (isset($_POST['submit'])) {
    $stopLoop = false;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "iot";
    
    // Create a connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM junction WHERE id = 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $npolygon = array(
        array($row['n1_lat'], $row['n1_lon']),
        array($row['n2_lat'], $row['n2_lon']),
        array($row['n3_lat'], $row['n3_lon']),
        array($row['n4_lat'], $row['n4_lon'])
      );
      $wpolygon = array(
        array($row['w1_lat'], $row['w1_lon']),
        array($row['w2_lat'], $row['w2_lon']),
        array($row['w3_lat'], $row['w3_lon']),
        array($row['w4_lat'], $row['w4_lon'])
      );
      $spolygon = array(
        array($row['s1_lat'], $row['s1_lon']),
        array($row['s2_lat'], $row['s2_lon']),
        array($row['s3_lat'], $row['s3_lon']),
        array($row['s4_lat'], $row['s4_lon'])
      );
      $epolygon = array(
        array($row['e1_lat'], $row['e1_lon']),
        array($row['e2_lat'], $row['e2_lon']),
        array($row['e3_lat'], $row['e3_lon']),
        array($row['e4_lat'], $row['e4_lon'])
      );
    }
    while (!$stopLoop) {
      $ncount = 0;
      $wcount = 0;
      $scount = 0;
      $ecount = 0;
      $sq = "SELECT * FROM traffic_data";
      $results = $conn->query($sq);
      if ($results && $results->num_rows > 0) {
        while ($rows = $results->fetch_assoc()) {
          $point = array($rows['lat'], $rows['lon']);
          if(performCalculation($point, $npolygon))
            $ncount += 1; 
          elseif(performCalculation($point, $wpolygon))
            $wcount += 1;
          elseif(performCalculation($point, $spolygon))
            $scount += 1;
          elseif(performCalculation($point, $epolygon))
            $ecount += 1;
        }
      }
      $filename = 'output.txt';
      $fileContent = $ncount . " " . $wcount . " " . $scount . " " . $ecount;
      file_put_contents($filename, $fileContent);
          
      // Check if the stop button is pressed
      if (isset($_POST['stop'])) {
        // Stop the loop
        $stopLoop = true;
      }
      // Wait for 40 seconds
      sleep(10);
    }
  }
  ?>

  <!-- HTML form -->
  <form method="POST" action="">
    <!-- Form inputs here -->

    <input type="submit" name="submit" value="Calculate">
    <input type="submit" name="stop" value="Stop">
  </form>
</body>
</html>
