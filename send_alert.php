<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: signin.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_tracking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emergency_type = isset($_POST['emergency_type']) ? $_POST['emergency_type'] : '';
$student_id = $_SESSION['student_id'];
$last_name = $_SESSION['last_name'];
$first_name = $_SESSION['first_name'];
$middle_name = $_SESSION['middle_name'];
$extension = $_SESSION['extension'];
$mobile_no = $_SESSION['mobile_no'];
$email = $_SESSION['email'];
$year_level = $_SESSION['year_level'];
$section = $_SESSION['section'];
$program = $_SESSION['program'];
$emergency_no = $_SESSION['emergency_no'];
$emergency_name = $_SESSION['emergency_name'];
$latitude = isset($_POST['latitude']) ? $_POST['latitude'] : null;
$longitude = isset($_POST['longitude']) ? $_POST['longitude'] : null;

$image_path = null;

if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $fileTmpPath = $_FILES['photo']['tmp_name'];
    $fileName = $_FILES['photo']['name'];
    $fileSize = $_FILES['photo']['size'];
    $fileType = $_FILES['photo']['type'];

    $uploadDirectory = 'uploads/';
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $newFileName = uniqid() . '_' . basename($fileName);
    $uploadPath = $uploadDirectory . $newFileName;

    if (move_uploaded_file($fileTmpPath, $uploadPath)) {
        $image_path = $uploadPath;
    } else {
        echo "There was an error uploading the image.";
        exit();
    }
}

$stmt = $conn->prepare("INSERT INTO emergency_reports (student_id, last_name, first_name, middle_name, extension, mobile_no, email, year_level, section, program, emergency_type, emergency_name, emergency_no, latitude, longitude, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("isssssssssssssds", $student_id, $last_name, $first_name, $middle_name, $extension, $mobile_no, $email, $year_level, $section, $program, $emergency_type, $emergency_name, $emergency_no, $latitude, $longitude, $image_path);

if ($stmt->execute()) {
    echo "Your alert has been submitted, the response team will contact you shortly.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
