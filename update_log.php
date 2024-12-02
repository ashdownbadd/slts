<?php
$host = 'localhost';
$db = 'student_tracking';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$log_id = $_GET['log_id'];

$sql = "SELECT * FROM logs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $log_id);
$stmt->execute();
$result = $stmt->get_result();
$log = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];

    $update_sql = "UPDATE logs SET status=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('si', $status, $log_id);
    $update_stmt->execute();

    header("Location: view_logs.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Log</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
                url('color-css/ccchaos.svg');
            background-color: #CEE470;
            background-size: cover;
            color: #333;
        }

        h1 {
            text-align: left;
            color: #4C3491;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .log-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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
            justify-content: space-between;
            text-align: center;
        }

        .log-header div {
            flex: 1;
            text-align: center;
        }

        .log-row {
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s ease-in-out;
            justify-content: space-between;
        }

        .log-row div {
            flex: 1;
            font-size: 14px;
            color: #555;
            text-align: center;
        }

        .actor-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
        }

        .actor-icon i {
            color: #4C3491;
            font-size: 16px;
        }


        input[type="text"],
        select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #f9f9f9;
            font-size: 14px;
            color: #555;
            text-align: center;
        }

        .save-button {
            margin-left: 15px;
            background-color: #6D4AD0;
            color: white;
            font-size: 14px;
            font-weight: bold;
            height: 36px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .save-button:hover {
            background-color: #45a049;
        }

        .log-row input[readonly],
        .log-row select[readonly] {
            background-color: #f9f9f9;
            cursor: not-allowed;
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
    </style>
</head>

<body>
    <div class="log-container">
        <div class="log-header">
            <div>Assigned Personnel</div>
            <div>Student</div>
            <div>Program</div>
            <div>Emergency Type</div>
            <div>Date and Time</div>
            <div>Status</div>
            <div>Actions</div>
        </div>

        <div class="log-row">
            <div class="actor-icon">
                <?php echo htmlspecialchars($log['actor']); ?>
            </div>
            <div><?php echo htmlspecialchars($log['student_name']); ?></div>
            <div><?php echo htmlspecialchars($log['program']); ?></div>
            <div><?php echo htmlspecialchars($log['emergency_type']); ?></div>
            <div>
                <?php echo htmlspecialchars($log['date']); ?><br>
                <?php echo htmlspecialchars($log['time']); ?>
            </div>
            <div>
                <form action="update_log.php?log_id=<?php echo $log['id']; ?>" method="POST">
                    <select name="status">
                        <option value="Pending" <?php if ($log['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Resolved" <?php if ($log['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                        <option value="Escalated" <?php if ($log['status'] == 'Escalated') echo 'selected'; ?>>Escalated</option>
                    </select>
                    <button type="submit" class="save-button">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>