<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_tracking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['firstname']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $checkUsername = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($checkUsername);

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Username already exists. Please choose a different username.');
                window.history.back(); // Redirects the user back to the form
              </script>";
    } else {
        $role = "admin";

        $sql = "INSERT INTO admin (name, email, username, password, role) 
                VALUES ('$fullname', '$email', '$username', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Registration successful!');
                    window.location.href = 'home.html';
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
