<?php

// Create connection
$conn = new mysqli('localhost', 'root', '', 'emergency_waitlist');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful";
}
