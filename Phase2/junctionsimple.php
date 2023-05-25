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
    $a = $_POST["a"];
    $ar = explode(",", $a);
    $n1_lat = trim($ar[0]);
    $n1_lon = trim($ar[1]);
    $n2_lat = trim($ar[2]);
    $n2_lon = trim($ar[3]);
    $n3_lat = trim($ar[4]);
    $n3_lon = trim($ar[5]);
    $n4_lat = trim($ar[6]);
    $n4_lon = trim($ar[7]);
    $w1_lat = trim($ar[8]);
    $w1_lon = trim($ar[9]);
    $w2_lat = trim($ar[10]);
    $w2_lon = trim($ar[11]);
    $w3_lat = trim($ar[12]);
    $w3_lon = trim($ar[13]);
    $w4_lat = trim($ar[14]);
    $w4_lon = trim($ar[15]);
    $s1_lat = trim($ar[16]);
    $s1_lon = trim($ar[17]);
    $s2_lat = trim($ar[18]);
    $s2_lon = trim($ar[19]);
    $s3_lat = trim($ar[20]);
    $s3_lon = trim($ar[21]);
    $s4_lat = trim($ar[22]);
    $s4_lon = trim($ar[23]);
    $e1_lat = trim($ar[24]);
    $e1_lon = trim($ar[25]);
    $e2_lat = trim($ar[26]);
    $e2_lon = trim($ar[27]);
    $e3_lat = trim($ar[28]);
    $e3_lon = trim($ar[29]);
    $e4_lat = trim($ar[30]);
    $e4_lon = trim($ar[31]);

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
        <form method="post" action="junctionsimple.php">
            <div class="form-group">
                <label>All:</label>
                <br>
                <input type="text" name="a" placeholder="All" required>
                            
                
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
