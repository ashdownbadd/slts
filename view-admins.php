<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_tracking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM admin WHERE id = '$deleteId'";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>
                alert('Admin deleted successfully!');
                window.location.href = 'view-admins.php';
              </script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$sql = "SELECT * FROM admin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized Personnel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="icon_planet.jpg">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #CEE470;
            background-image: url('background.svg');
            background-size: cover;
            color: #333;
        }

        .log-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
        }

        .log-header,
        .log-row {
            display: flex;
            align-items: center;
            padding: 15px 20px;
        }

        .log-header {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
            font-size: 14px;
            display: flex;
            justify-content: center;
            text-align: center;
        }

        .log-header div {
            flex: 1;
            text-align: center;
        }

        .log-row {
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s ease-in-out;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .log-row div {
            flex: 1;
            font-size: 14px;
            color: #555;
            text-align: center;
        }

        .delete-btn {
            padding: 10px 15px;
            background-color: #6D4AD0;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #6f4db5;
        }

        @media (max-width: 480px) {

            .log-header,
            .log-row {
                flex-direction: column;
                text-align: center;
                padding: 10px;
            }

            .log-header div,
            .log-row div {
                width: 100%;
            }
        }

        @media (min-width: 481px) and (max-width: 768px) {

            .log-header,
            .log-row {
                padding: 10px 15px;
            }

            .log-header div,
            .log-row div {
                font-size: 12px;
            }
        }

        .circular-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 56px;
            height: 56px;
            background-color: #CFFF5E;
            color: #161616;
            border: none;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
        }

        .circular-btn:hover {
            background-color: #6D4AD0;
            transform: scale(1.1);
        }

        .circular-btn a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="log-container">
        <div class="log-header">
            <div>ID</div>
            <div>Full Name</div>
            <div>Email</div>
            <div>Username</div>
            <div>Action</div>
        </div>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='log-row'>
                        <div>" . $row['id'] . "</div>
                        <div>" . htmlspecialchars($row['name']) . "</div>
                        <div>" . htmlspecialchars($row['email']) . "</div>
                        <div>" . htmlspecialchars($row['username']) . "</div>
                        <div>
                            <a href='view-admins.php?delete_id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this admin?');\">
                                <button class='delete-btn'>Delete</button>
                            </a>
                        </div>
                      </div>";
            }
        } else {
            echo "<div class='log-row'><div colspan='5'>No admins found.</div></div>";
        }
        ?>
    </div>

    <a href="reg-admin.html" class="circular-btn">
        <i class="fas fa-plus"></i>
    </a>

</body>

</html>

<?php
$conn->close();
?>