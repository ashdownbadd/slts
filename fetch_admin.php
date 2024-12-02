<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$username = $_SESSION['username'];

$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "student_tracking";

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullName = $row["name"];
} else {
    $fullName = "User not found";
}

$stmt->close();
$conn->close();

echo json_encode(["fullName" => $fullName]);
