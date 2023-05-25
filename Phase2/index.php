<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 300px;
            margin: 0 auto;
        }

        label, input {
            display: block;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <label for="vehicle_id">Vehicle ID:</label>
        <input type="text" id="vehicle_id" name="vehicle_id" required>

        <label for="owner_name">Owner Name:</label>
        <input type="text" id="owner_name" name="owner_name" required>

        <input type="submit" value="Submit">
    </form>

    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $vehicle_id = $_POST['vehicle_id'];
        $owner_name = $_POST['owner_name'];

        // Connect to database (replace with your database credentials)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "iot";

        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert data into table
        $sql = "INSERT INTO traffic_data (vehicle_id, owner_name) VALUES ('$vehicle_id', '$owner_name')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Data inserted successfully.</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>

    <h2>Registered Vehicles</h2>
    <table>
        <tr>
            <th>Vehicle ID</th>
            <th>Owner Name</th>
            <th>Latitude</th>
            <th>Longitude</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "iot";
        // Connect to database (replace with your database credentials)
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from table
        $sql = "SELECT vehicle_id, owner_name, lat, lon  FROM traffic_data";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["vehicle_id"] . "</td><td>" . $row["owner_name"] . "</td><td>" . $row["lat"] . "</td><td>" . $row["lon"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No registered vehicles found.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
