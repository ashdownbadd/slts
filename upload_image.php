<?php
// upload_image.php

session_start();
header('Content-Type: application/json');

require_once 'config.php'; // Ensure your database connection is here

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['imageData'])) {
    // Decode the base64 image data
    $imageData = $data['imageData'];
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);
    $decodedImage = base64_decode($imageData);

    // Define the file path and save the image
    $filePath = 'uploads/' . uniqid() . '.png';
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }
    file_put_contents($filePath, $decodedImage);

    // Store the image path in the database
    $student_id = $_SESSION['student_id']; // assuming student_id is in the session
    $stmt = $conn->prepare("INSERT INTO emergency_reports (student_id, image_path) VALUES (?, ?)");
    $stmt->bind_param("is", $student_id, $filePath);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Image uploaded successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No image attached.']);
}
?>
