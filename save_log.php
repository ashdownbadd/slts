<?php
$host = 'localhost';
$db = 'student_tracking';
$user = 'root';
$pass = '';

date_default_timezone_set('Asia/Manila');

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$actor = isset($_GET['actor']) ? $conn->real_escape_string($_GET['actor']) : 'Unknown';
$student_name = isset($_GET['student_name']) ? $conn->real_escape_string($_GET['student_name']) : 'Unknown';
$program = isset($_GET['program']) ? $conn->real_escape_string($_GET['program']) : 'Unknown';
$emergency_type = isset($_GET['emergency_type']) ? $conn->real_escape_string($_GET['emergency_type']) : 'Unknown';
$date = date('Y-m-d');
$time = date('H:i:s');
$status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : 'Pending';

$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

$sql = "INSERT INTO logs (actor, student_name, program, emergency_type, date, time, status)
        VALUES ('$actor', '$student_name', '$program', '$emergency_type', '$date', '$time', '$status')";

if ($conn->query($sql) === TRUE) {
  echo "success";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
