<?php
session_start();

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "student_tracking";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT student_id, password, role, last_name, first_name, middle_name, extension, mobile_no, email, year_level, section, program, emergency_no, emergency_name FROM student WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($student_id, $db_password, $role, $last_name, $first_name, $middle_name, $extension, $mobile_no, $email, $year_level, $section, $program, $emergency_no, $emergency_name);
        $stmt->fetch();

        if (password_verify($password, $db_password)) {
            $_SESSION['student_id'] = $student_id;
            $_SESSION['username'] = $username;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['middle_name'] = $middle_name;
            $_SESSION['extension'] = $extension;
            $_SESSION['mobile_no'] = $mobile_no;
            $_SESSION['email'] = $email;
            $_SESSION['year_level'] = $year_level;
            $_SESSION['section'] = $section;
            $_SESSION['program'] = $program;
            $_SESSION['role'] = $role;
            $_SESSION['emergency_no'] = $emergency_no;
            $_SESSION['emergency_name'] = $emergency_name;

            header("Location: profile.php");
            exit();
        } elseif ($password === $db_password) {
            $_SESSION['student_id'] = $student_id;
            $_SESSION['username'] = $username;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['middle_name'] = $middle_name;
            $_SESSION['extension'] = $extension;
            $_SESSION['mobile_no'] = $mobile_no;
            $_SESSION['email'] = $email;
            $_SESSION['year_level'] = $year_level;
            $_SESSION['section'] = $section;
            $_SESSION['program'] = $program;
            $_SESSION['role'] = $role;
            $_SESSION['emergency_no'] = $emergency_no;
            $_SESSION['emergency_name'] = $emergency_name;

            header("Location: profile.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='signin.html';</script>";
        }
    } else {
        $stmt = $conn->prepare("SELECT id, password, role, name, email FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $db_password, $role, $name, $email);
                $stmt->fetch();

                if ($role !== 'admin') {
                    echo "<script>alert('Access Denied: Only admins can log in here.'); window.location.href='signin.html';</script>";
                    exit();
                }

                if (password_verify($password, $db_password)) {
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;

                    header("Location: home.html");
                    exit();
                } elseif ($password === $db_password) {
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;

                    header("Location: home.html");
                    exit();
                } else {
                    echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='signin.html';</script>";
                }
            } else {
                echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='signin.html';</script>";
            }
        } else {
            echo "Query error: " . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: signin.html");
    exit();
}
