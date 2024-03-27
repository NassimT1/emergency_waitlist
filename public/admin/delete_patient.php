<?php
// Include your database connection script
require_once '../../database/db_connection.php';

// Check if the request is an AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
    $code = $_POST['code'];

    // Perform the SQL delete operation
    $sql = "DELETE FROM patient WHERE code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $code);

    if ($stmt->execute()) {
        // Return a JSON response indicating success
        echo json_encode(['success' => true]);
    } else {
        // Return a JSON response indicating failure
        echo json_encode(['success' => false]);
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>