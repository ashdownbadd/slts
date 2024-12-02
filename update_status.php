<?php
$host = 'localhost';
$db = 'student_tracking';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$log_id = $_POST['id'];
$new_status = $_POST['status'];

$sql = "UPDATE logs SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_status, $log_id);

if ($stmt->execute()) {
    echo "Status updated successfully!";
} else {
    echo "Error updating status.";
}

$stmt->close();
$conn->close();
