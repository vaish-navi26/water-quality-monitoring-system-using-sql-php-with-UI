<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $water_body_id = $_POST['water_body_id'];
    $pH = $_POST['pH'] . " pH"; // Append unit to pH value
    $temperature = $_POST['temperature'] . " °C"; // Append unit to temperature value
    $dissolved_oxygen = $_POST['dissolved_oxygen'] . " mg/L"; // Append unit to dissolved oxygen value
    $nitrogen = $_POST['nitrogen'] . " mg/L"; // Append unit to nitrogen value
    $phosphorus = $_POST['phosphorus'] . " mg/L"; // Append unit to phosphorus value
    $total_suspended_solids = $_POST['total_suspended_solids'] . " mg/L"; // Append unit to total suspended solids value
    $total_coliforms = $_POST['total_coliforms'] . " MPN/100 mL"; // Append unit to total coliforms value
    $e_coli = $_POST['e_coli'] . " MPN/100 mL"; // Append unit to E. coli value
    $algal_blooms = $_POST['algal_blooms']; // No need to append unit here

    // Include database connection
    include 'db_connection.php';

    // Prepare and execute SQL statement to insert data into LabAnalysisResults table
    $sql = "INSERT INTO LabAnalysisResults (WaterBodyID, pH, Temperature, DissolvedOxygen, Nitrogen, Phosphorus, 
            TotalSuspendedSolids, TotalColiforms, EColi, AlgalBlooms, Timestamp) 
            VALUES ('$water_body_id', '$pH', '$temperature', '$dissolved_oxygen', '$nitrogen', '$phosphorus', 
            '$total_suspended_solids', '$total_coliforms', '$e_coli', '$algal_blooms', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Lab analysis results submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Form not submitted.";
}
?>
