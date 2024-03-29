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

        $currentPatientArrivalTime = null;
        $previousPatientArrivalTime = null;

        // Retrieve the current patient's arrival time
        $sqlCurrentPatient = "SELECT arrivalTime FROM patient WHERE code = ? AND lastName = ?";
        $stmt = $conn->prepare($sqlCurrentPatient);
        $stmt->bind_param("ss", $code, $lastName);
        $stmt->execute();
        $result = $stmt->get_result();
        $currentPatient = $result->fetch_assoc();
        $currentPatientArrivalTime = $currentPatient['arrivalTime'];

        // Retrieve the previous patient's arrival time, if current patient's arrival time is available
        if ($currentPatientArrivalTime !== null) {
            $sqlPreviousPatient = "SELECT arrivalTime FROM patient WHERE arrivalTime < ? ORDER BY arrivalTime DESC LIMIT 1";
            $stmt = $conn->prepare($sqlPreviousPatient);
            $stmt->bind_param("s", $currentPatientArrivalTime);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $previousPatient = $result->fetch_assoc();
                $previousPatientArrivalTime = $previousPatient['arrivalTime'];
            } 
        }

        // Subtract the previous arrival time from the current patient 
        if ($currentPatientArrivalTime !== null) {
            $currentPatientTimestamp = strtotime($currentPatientArrivalTime);
            $previousPatientTimestamp = strtotime($previousPatientArrivalTime);
            $timeDifferenceInSeconds = $currentPatientTimestamp - $previousPatientTimestamp;
            $timeDifference = $timeDifferenceInSeconds / 60;        
        } else {
            $timeDifference = 0;
        }
        // Estimate the waiting time by multiplying sum of severity by 5 
        $totalSeverity = $row['totalSeverity'];
        $estimatedWaitingTime = $totalSeverity * 5 - $timeDifference;

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
    <div class="grid-container">
        <div class="grid-item">Your position in the waitlist:</div>
        <div class="grid-item"><?php echo $position; ?></div>
        <div class="grid-item">Estimated waiting time:</div>
        <div class="grid-item"><?php echo round($adjustedWaitingTime); ?> minutes</div>
        <div class="grid-item" style="grid-column: span 2;">
            <?php 
            if ($position == 0) {
                echo "It's your turn!";
            } else if($position>0 and $adjustedWaitingTime==0) {
                echo "It's your turn soon. Please be ready.";
            } else {
                echo "Please wait for your turn.";
            }
            ?>
        </div>
    </div>
    <p class="center">(This page automatically refreshes every minute)</p>
    <script>
        // Refresh the page every minute
        setTimeout(function(){
            window.location.reload(1);
        }, 60000); 
    </script>
</body>
</html>
