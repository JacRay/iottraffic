<!DOCTYPE html>
<html>
<head>
    <title>Enter Junction Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }
        
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }
        
        .form-group input {
            width: 200px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }
        
        .table-container {
            margin-top: 30px;
        }
        
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-container th,
        .table-container td {
            padding: 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
<?php
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve latitude and longitude values from the form
    $n1 = $_POST["n1"];
    $n2 = $_POST["n2"];
    $n3 = $_POST["n3"];
    $n4 = $_POST["n4"];
    $n1c = explode(",", $n1);
    $n1_lat = trim($n1c[0]);
    $n1_lon = trim($n1c[1]);
    $n2c = explode(",", $n2);
    $n2_lat = trim($n2c[0]);
    $n2_lon = trim($n2c[1]);
    $n3c = explode(",", $n3);
    $n3_lat = trim($n3c[0]);
    $n3_lon = trim($n3c[1]);
    $n4c = explode(",", $n4);
    $n4_lat = trim($n4c[0]);
    $n4_lon = trim($n4c[1]);

    $w1 = $_POST["w1"];
    $w2 = $_POST["w2"];
    $w3 = $_POST["w3"];
    $w4 = $_POST["w4"];
    $w1c = explode(",", $w1);
    $w1_lat = trim($w1c[0]);
    $w1_lon = trim($w1c[1]);
    $w2c = explode(",", $w2);
    $w2_lat = trim($w2c[0]);
    $w2_lon = trim($w2c[1]);
    $w3c = explode(",", $w3);
    $w3_lat = trim($w3c[0]);
    $w3_lon = trim($w3c[1]);
    $w4c = explode(",", $w4);
    $w4_lat = trim($w4c[0]);
    $w4_lon = trim($w4c[1]);

    $s1 = $_POST["s1"];
    $s2 = $_POST["s2"];
    $s3 = $_POST["s3"];
    $s4 = $_POST["s4"];
    $s1c = explode(",", $s1);
    $s1_lat = trim($s1c[0]);
    $s1_lon = trim($s1c[1]);
    $s2c = explode(",", $s2);
    $s2_lat = trim($s2c[0]);
    $s2_lon = trim($s2c[1]);
    $s3c = explode(",", $s3);
    $s3_lat = trim($s3c[0]);
    $s3_lon = trim($s3c[1]);
    $s4c = explode(",", $s4);
    $s4_lat = trim($s4c[0]);
    $s4_lon = trim($s4c[1]);

    $e1 = $_POST["e1"];
    $e2 = $_POST["e2"];
    $e3 = $_POST["e3"];
    $e4 = $_POST["e4"];
    $e1c = explode(",", $e1);
    $e1_lat = trim($e1c[0]);
    $e1_lon = trim($e1c[1]);
    $e2c = explode(",", $e2);
    $e2_lat = trim($e2c[0]);
    $e2_lon = trim($e2c[1]);
    $e3c = explode(",", $e3);
    $e3_lat = trim($e3c[0]);
    $e3_lon = trim($e3c[1]);
    $e4c = explode(",", $e4);
    $e4_lat = trim($e4c[0]);
    $e4_lon = trim($e4c[1]);

    // Prepare and execute the SQL statement to insert the values into the table
    $sql = "UPDATE junction SET 
    n1_lat ='$n1_lat',
    n1_lon ='$n1_lon', 
    n2_lat ='$n2_lat',
    n2_lon ='$n2_lon',
    n3_lat ='$n3_lat',
    n3_lon ='$n3_lon',
    n4_lat ='$n4_lat',
    n4_lon ='$n4_lon',
    w1_lat ='$w1_lat',
    w1_lon ='$w1_lon', 
    w2_lat ='$w2_lat',
    w2_lon ='$w2_lon',
    w3_lat ='$w3_lat',
    w3_lon ='$w3_lon',
    w4_lat ='$w4_lat',
    w4_lon ='$w4_lon',
    s1_lat ='$s1_lat',
    s1_lon ='$s1_lon', 
    s2_lat ='$s2_lat',
    s2_lon ='$s2_lon',
    s3_lat ='$s3_lat',
    s3_lon ='$s3_lon',
    s4_lat ='$s4_lat',
    s4_lon ='$s4_lon',
    e1_lat ='$e1_lat',
    e1_lon ='$e1_lon', 
    e2_lat ='$e2_lat',
    e2_lon ='$e2_lon',
    e3_lat ='$e3_lat',
    e3_lon ='$e3_lon',
    e4_lat ='$e4_lat',
    e4_lon ='$e4_lon'
    WHERE id = 1";
            
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch data from the "junction" table
$sql = "SELECT * FROM junction";
$result = $conn->query($sql);
?>
 
    <div class="container">
        <h2>Enter Junction Data</h2>
        <form method="post" action="junction.php">
            <div class="form-group">
                <label>North:</label>
                <br>
                <input type="text" name="n1" placeholder="Latitude,Longitude 1" required>
                <input type="text" name="n2" placeholder="Latitude,Longitude 2" required>
                <input type="text" name="n3" placeholder="Latitude,Longitude 3" required>
                <input type="text" name="n4" placeholder="Latitude,Longitude 4" required>
            </div>
            <div class="form-group">
                <label>West:</label>
                <br>
                <input type="text" name="w1" placeholder="Latitude,Longitude 1" required>
                <input type="text" name="w2" placeholder="Latitude,Longitude 2" required>
                <input type="text" name="w3" placeholder="Latitude,Longitude 3" required>
                <input type="text" name="w4" placeholder="Latitude,Longitude 4" required>
            </div>
            <div class="form-group">
                <label>South:</label>
                <br>
                <input type="text" name="s1" placeholder="Latitude,Longitude 1" required>
                <input type="text" name="s2" placeholder="Latitude,Longitude 2" required>
                <input type="text" name="s3" placeholder="Latitude,Longitude 3" required>
                <input type="text" name="s4" placeholder="Latitude,Longitude 4" required>
            </div>
            <div class="form-group">
                <label>East:</label>
                <br>
                <input type="text" name="e1" placeholder="Latitude,Longitude 1" required>
                <input type="text" name="e2" placeholder="Latitude,Longitude 2" required>
                <input type="text" name="e3" placeholder="Latitude,Longitude 3" required>
                <input type="text" name="e4" placeholder="Latitude,Longitude 4" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
    
    <div class="table-container">
        <h2>Junction Data</h2>
        <table>
            <tr>
                <th>North</th>
                <th>West</th>
                <th>South</th>
                <th>East</th>
            </tr>
            <?php
            // Display the fetched data in table rows
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["n1_lat"] . ", " . $row["n1_lon"] . ", " . $row["n2_lat"] . ", " . $row["n2_lon"] . ", " . $row["n3_lat"] . ", " . $row["n3_lon"] . ", " . $row["n4_lat"] . ", " . $row["n4_lon"] ."</td>";
                    echo "<td>" . $row["w1_lat"] . ", " . $row["w1_lon"] . ", " . $row["w2_lat"] . ", " . $row["w2_lon"] . ", " . $row["w3_lat"] . ", " . $row["w3_lon"] . ", " . $row["w4_lat"] . ", " . $row["w4_lon"] ."</td>";
                    echo "<td>" . $row["s1_lat"] . ", " . $row["s1_lon"] . ", " . $row["s2_lat"] . ", " . $row["s2_lon"] . ", " . $row["s3_lat"] . ", " . $row["s3_lon"] . ", " . $row["s4_lat"] . ", " . $row["s4_lon"] ."</td>";
                    echo "<td>" . $row["e1_lat"] . ", " . $row["e1_lon"] . ", " . $row["e2_lat"] . ", " . $row["e2_lon"] . ", " . $row["e3_lat"] . ", " . $row["e3_lon"] . ", " . $row["e4_lat"] . ", " . $row["e4_lon"] ."</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No data available</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
