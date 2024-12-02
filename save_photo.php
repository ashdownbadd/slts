<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_tracking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if photo data is received
if (isset($_POST['photo_data'])) {
    $photoData = $_POST['photo_data'];

    // Decode base64 image data
    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photoData));

    // Generate a unique filename
    $fileName = 'emergency_' . time() . '.png';
    $filePath = 'uploads/' . $fileName;

    // Save image to server
    file_put_contents($filePath, $imageData);

    // Insert image path into the database
    $sql = "INSERT INTO emergency_reports (image_path) VALUES ('$filePath')";

    if ($conn->query($sql) === TRUE) {
        echo "Image saved to database successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
