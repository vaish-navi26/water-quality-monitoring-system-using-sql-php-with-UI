<?php
// Include database connection
include 'db_connection.php';

// Initialize variables
$water_body_report = '';
$lab_analysis_report = '';

// Retrieve all Water Body IDs
$sql_water_body_ids = "SELECT WaterBodyID FROM Water_Bodies";
$result_water_body_ids = $conn->query($sql_water_body_ids);

// Check if there are rows returned
if ($result_water_body_ids->num_rows > 0) {
    // Store Water Body IDs in an array
    $water_body_ids = array();
    while ($row = $result_water_body_ids->fetch_assoc()) {
        $water_body_ids[] = $row["WaterBodyID"];
    }
} else {
    $water_body_report = "No water bodies found.";
}

// Close the previous query result
$result_water_body_ids->close();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected Water Body ID
    $selected_water_body_id = $_POST['water_body_id'];

    // Retrieve data from Water_Bodies table for the selected Water Body ID
    $sql_water_body_data = "SELECT * FROM Water_Bodies WHERE WaterBodyID = '$selected_water_body_id'";
    $result_water_body_data = $conn->query($sql_water_body_data);

    // Check if there are rows returned
    if ($result_water_body_data->num_rows > 0) {
        // Output report header for Water Bodies
        $water_body_report .= "<h2>Water Body Report</h2>";
        $water_body_report .= "<table border='1'>";
        $water_body_report .= "<tr><th>Water Body ID</th><th>Name</th><th>Type</th><th>Location</th><th>Area (sq km)</th></tr>";

        // Output data of each row for the selected Water Body
        while ($row = $result_water_body_data->fetch_assoc()) {
            $water_body_report .= "<tr>";
            $water_body_report .= "<td>" . $row["WaterBodyID"] . "</td>";
            $water_body_report .= "<td>" . $row["Name"] . "</td>";
            $water_body_report .= "<td>" . $row["Type"] . "</td>";
            $water_body_report .= "<td>" . $row["Location"] . "</td>";
            $water_body_report .= "<td>" . $row["Area"] . "</td>";
            $water_body_report .= "</tr>";
        }
        $water_body_report .= "</table>";
    } else {
        $water_body_report = "Water body not found.";
    }

    // Close the previous query result
    $result_water_body_data->close();

    // Retrieve lab analysis results for the selected Water Body ID
    $sql_lab_results = "SELECT * FROM LabAnalysisResults WHERE WaterBodyID = '$selected_water_body_id'";
    $result_lab_results = $conn->query($sql_lab_results);

    // Check if there are rows returned from LabAnalysisResults table
    if ($result_lab_results->num_rows > 0) {
        // Output report header for Lab Analysis Results
        $lab_analysis_report .= "<h2>Lab Analysis Report</h2>";
        $lab_analysis_report .= "<table border='1'>";
        $lab_analysis_report .= "<tr><th>Analysis ID</th><th>pH</th><th>Temperature</th><th>Dissolved Oxygen</th><th>Nitrogen</th><th>Phosphorus</th><th>Total Suspended Solids</th><th>Total Coliforms</th><th>E. coli</th><th>Algal Blooms</th><th>Timestamp</th></tr>";

        // Output data of each row for Lab Analysis Results
        while ($row = $result_lab_results->fetch_assoc()) {
            $lab_analysis_report .= "<tr>";
            $lab_analysis_report .= "<td>" . $row["AnalysisID"] . "</td>";
            $lab_analysis_report .= "<td>" . $row["pH"] . "</td>";
            $lab_analysis_report .= "<td>" . $row["Temperature"] . "</td>";
            $lab_analysis_report .= "<td>" . $row["DissolvedOxygen"] . "</td>";
            $lab_analysis_report .= "<td>" . $row["Nitrogen"] . "</td>";
            $lab_analysis_report .= "<td>" . $row["Phosphorus"] . "</td>";
            $lab_analysis_report .= "<td>" . $row["TotalSuspendedSolids"] . "</td>";
            $lab_analysis_report .= "<td>" . $row["TotalColiforms"] . "</td>";
            $lab_analysis_report .= "<td>" . $row["EColi"] . "</td>";
            $lab_analysis_report .= "<td>" . $row["AlgalBlooms"] . "</td>";
            $lab_analysis_report .= "<td>" . $row["Timestamp"] . "</td>";
            $lab_analysis_report .= "</tr>";
        }
        $lab_analysis_report .= "</table>";
    } else {
        $lab_analysis_report = "No lab analysis results found for this water body.";
    }

    // Close the previous query result
    $result_lab_results->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Body Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            background-color: #007bff; /* Blue background */
            color: #fff; /* White font color */
            padding: 10px 0; /* Add padding */
        }

        nav {
            background-color: #007bff;
            color: #fff;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #fff;
            color: #007bff;
        }
    </style>
</head>
<body>
<nav>
    <a href="home.html">Home</a>
    <a href="waterbody.html">Water Body</a>
    <a href="labanalysis.html">Laboratory Analysis</a>
    <a href="report.php"> Report </a>
</nav>
<?php
echo $water_body_report;
echo $lab_analysis_report;
?>
<h2>Analysis Report</h2>
<h3>Select a Water Body</h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="water_body_id">Water Body ID:</label>
    <select id="water_body_id" name="water_body_id">
        <?php
        // Output dropdown options for Water Body IDs
        foreach ($water_body_ids as $id) {
            echo "<option value='$id'>$id</option>";
        }
        ?>
    </select>
    <input type="submit" value="Submit">
</form>
</body>
</html>
