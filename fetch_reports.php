<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_tracking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT student_id, 
CONCAT(first_name, ' ' , middle_name, ' ' , last_name , ' ' , extension) AS full_name, mobile_no, email, year_level, section, program, emergency_type, emergency_name, emergency_no, report_date, latitude, longitude, image_path FROM emergency_reports ORDER BY report_id DESC";
$result = $conn->query($sql);

$reports = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['image_path']) {
            $row['image_url'] = $row['image_path'];
        } else {
            $row['image_url'] = null;
        }
        $reports[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($reports);
