<?php
require_once '../../database/db_connection.php';

// Generate a random 5 lettered code 
function generateRandomCode($length = 5) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $severity = $_POST['severity'];

    $code = generateRandomCode();
    $arrivalTime = date('Y-m-d H:i:s');

    $sql = "INSERT INTO patient (code, firstName, lastName, severity, arrivalTime) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $code, $firstName, $lastName, $severity, $arrivalTime);

    $stmt->execute();
    echo $code;

    $stmt->close();
    $conn->close();
}
