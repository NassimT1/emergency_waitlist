<?php
session_start();
require_once '../../database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    $lastName = $_POST['lastName'];

    // Get the patient using the code and lastName
    $sql = "SELECT * FROM patient WHERE code = ? AND lastName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $code, $lastName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        
        // Sort by arrival time
        $arrivalTime = $patient['arrivalTime'];
        $sql = "SELECT COUNT(*) AS position, SUM(severity) AS totalSeverity FROM patient WHERE arrivalTime < ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $arrivalTime);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        // Return the position of the patient
        $position = $row['position']; 
        
        // Estimate the waiting time by multiplying sum of severity by 5 
        $totalSeverity = $row['totalSeverity'];
        $estimatedWaitingTime = $totalSeverity * 5; 

        // Adjust the waiting time based on the current time
        $timePassed = (strtotime("now") - strtotime($arrivalTime)) / 60; // Time passed in minutes
        $adjustedWaitingTime = max(0, $estimatedWaitingTime - $timePassed);
    } else {
        echo "<script>alert('Invalid Code or Last Name. Please try again.'); window.location.href='patient.php';</script>";
        exit;
    }
} else {
    header("Location: patient.php");
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Waitlist</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
    <h1>Waitlist</h1><hr>
    <p>Your position in the waitlist: <?php echo $position; ?></p>
    <?php 
    if ($position == 0) {
        echo "<p>It's your turn!</p>";
    }
    else if ($adjustedWaitingTime > 0) {
        echo "<p> Estimated waiting time: " . round($adjustedWaitingTime) . " minutes </p>";
    } else {
        echo "<p> It's your turn soon. Please be ready. </p>"; // If waiting time is less than 0, but still people ahead
    }
    ?>
    <p>(This page automatically refreshes every 30 seconds)</p>
    <script>
        // Refresh the page every 30 seconds and update the estimate every minute
        setTimeout(function(){
            window.location.reload(1);
        }, 30000); 
    </script>
</body>
</html>
