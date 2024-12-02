<?php
session_start(); // Start the session

// Database connection
$servername = "localhost"; // Change if needed
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "student_tracking"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $student_id = $_POST['student_id'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $extension = $_POST['extension'];
    $mobile_no = $_POST['mobile_no'];
    $email = $_POST['email'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];
    $program = $_POST['program'];
    $emergency_no = $_POST['emergency_no'];
    $emergency_name = $_POST['emergency_name'];

    // Prepare and bind the statement with 11 parameters
    $stmt = $conn->prepare("UPDATE student SET last_name=?, first_name=?, middle_name=?, extension=?, mobile_no=?, email=?, year_level=?, section=?, program=?, emergency_no=?, emergency_name=? WHERE student_id=?");
    $stmt->bind_param("ssssssssssss", $last_name, $first_name, $middle_name, $extension, $mobile_no, $email, $year_level, $section, $program, $emergency_no, $emergency_name, $student_id);

    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Record updated successfully!";
            // Trigger a JavaScript alert and redirect
            echo "<script>
                    alert('Record updated successfully!');
                    window.location.href = 'profile.php';
                  </script>";
        } else {
            echo "<script>alert('No changes were made to the record.');
                    window.location.href = 'profile.php';
                  </script>";
        }
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>
