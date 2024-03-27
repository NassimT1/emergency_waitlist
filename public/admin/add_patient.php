<?php
// Include your database connection script
require_once '../database/db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $severity = $_POST['severity'];

    // Generate code
    $code = ''; // Placeholder for the code
    $generateCodeUrl = 'generate_code.php';
    $response = file_get_contents($generateCodeUrl);
    $data = json_decode($response, true);
    if (isset($data['code'])) {
        $code = $data['code'];
    } else {
        // Handle error in code generation
        echo "Error generating code.";
        exit;
    }

    // Capture the current time
    $arrivalTime = date('Y-m-d H:i:s');

    // Insert data into database
    $sql = "INSERT INTO patients (firstName, lastName, severity, code, arrivalTime) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $code, $firstName, $lastName, $severity,  $arrivalTime);

    if ($stmt->execute()) {
        echo "New patient added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
