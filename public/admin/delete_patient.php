<?php
require_once '../../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code']) && isset($_POST['lastName'])) {
    $code = $_POST['code'];
    $lastName = $_POST['lastName'];

    // Delete patient using th code and lastName
    $sql = "DELETE FROM patient WHERE code = ? AND lastName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $code, $lastName);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
}
?>
