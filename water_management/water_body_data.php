<?php
// Include the database connection script
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $water_body_name = mysqli_real_escape_string($conn, $_POST['water_body_name']);
    $water_body_type = mysqli_real_escape_string($conn, $_POST['water_body_type']);
    $water_body_location = mysqli_real_escape_string($conn, $_POST['water_body_location']);
    $water_body_area = floatval($_POST['water_body_area']);
    $pollution_type = mysqli_real_escape_string($conn, $_POST['pollution_type']);
    $pollution_level = floatval($_POST['pollution_level']);
    $chemical_name = mysqli_real_escape_string($conn, $_POST['chemical_name']);
    $chemical_value = floatval($_POST['chemical_value']);
    $species_name = mysqli_real_escape_string($conn, $_POST['species_name']);
    $species_count = intval($_POST['species_count']);
    $temperature = floatval($_POST['temperature']);

    // Prepare SQL insert statements for each table
    $sql_water_body = "INSERT INTO Water_Bodies (Name, Type, Location, Area)
                       VALUES ('$water_body_name', '$water_body_type', '$water_body_location', $water_body_area)";
    $sql_pollution = "INSERT INTO PollutionLevels (WaterBodyID, PollutionType, Level, Timestamp)
                      VALUES (LAST_INSERT_ID(), '$pollution_type', $pollution_level, NOW())";
    $sql_chemical = "INSERT INTO ChemicalAttributes (WaterBodyID, ChemicalName, Value, Timestamp)
                     VALUES (LAST_INSERT_ID(), '$chemical_name', $chemical_value, NOW())";
    $sql_biological = "INSERT INTO BiologicalData (WaterBodyID, SpeciesName, Count, Timestamp)
                       VALUES (LAST_INSERT_ID(), '$species_name', $species_count, NOW())";
    $sql_temperature = "INSERT INTO TemperatureFluctuations (WaterBodyID, Temperature, Timestamp)
                        VALUES (LAST_INSERT_ID(), $temperature, NOW())";

    // Execute SQL insert statements
    if ($conn->query($sql_water_body) === TRUE) {
        $water_body_id = $conn->insert_id; // Get the ID of the last inserted water body
        // Insert data into other tables
        $conn->query($sql_pollution);
        $conn->query($sql_chemical);
        $conn->query($sql_biological);
        $conn->query($sql_temperature);
        echo "Data submitted successfully!";
    } else {
        echo "Error: " . $sql_water_body . "<br>" . $conn->error;
    }
} else {
    echo "Form not submitted.";
}

// Close the database connection
$conn->close();
?>
