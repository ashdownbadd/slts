<?php
// Include Composer's autoloader
require 'vendor/autoload.php';

// Database connection
$host = "localhost";
$dbUsername = "root"; 
$dbPassword = ""; 
$dbname = "student_tracking"; 

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];  // Assuming you are using student_id for identification
    $email = $_POST['email'];

    // Check if email exists in the database and matches student_id
    $sql = "SELECT * FROM student WHERE student_id='$student_id' AND email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email exists, generate a reset token
        $token = bin2hex(random_bytes(50)); // Generate a random token
        $expires = date("U") + 3600; // Token expires in 1 hour

        // Insert token into database
        $sql = "UPDATE student SET reset_token='$token', token_expires='$expires' WHERE student_id='$student_id' AND email='$email'";
        if ($conn->query($sql) === TRUE) {
            // Send email with reset link using PHPMailer

            // Create a new PHPMailer instance
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@gmail.com';  // Your Gmail email address
                $mail->Password = 'your-app-password';  // App Password (if using 2FA)
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;  // TLS encryption
                $mail->Port = 587;  // Use port 587 for TLS

                // Recipients
                $mail->setFrom('no-reply@yourwebsite.com', 'Your Website');
                $mail->addAddress($email); // Recipient's email

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Here is your password reset link: <a href='http://yourwebsite.com/reset_password.php?token=$token'>Reset Password</a>";

                // Send the email
                if ($mail->send()) {
                    echo "A password reset link has been sent to your email.";
                } else {
                    echo "Failed to send email: " . $mail->ErrorInfo;
                }
            } catch (Exception $e) {
                echo "Error sending email: " . $mail->ErrorInfo;
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "No account found with that student ID and email address.";
    }
}

// Close connection
$conn->close();
?>
