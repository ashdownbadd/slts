<?php
$host = 'localhost';
$db = 'student_tracking';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$actor_filter = isset($_GET['actor']) ? $_GET['actor'] : '';
$student_name_filter = isset($_GET['student_name']) ? $_GET['student_name'] : '';
$program_filter = isset($_GET['program']) ? $_GET['program'] : '';
$emergency_type_filter = isset($_GET['emergency_type']) ? $_GET['emergency_type'] : '';

$sql = "SELECT * FROM logs WHERE 1";
if ($actor_filter) {
    $sql .= " AND actor LIKE '%" . $conn->real_escape_string($actor_filter) . "%'";
}
if ($student_name_filter) {
    $sql .= " AND student_name LIKE '%" . $conn->real_escape_string($student_name_filter) . "%'";
}
if ($program_filter) {
    $sql .= " AND program = '" . $conn->real_escape_string($program_filter) . "'";
}
if ($emergency_type_filter) {
    $sql .= " AND emergency_type = '" . $conn->real_escape_string($emergency_type_filter) . "'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='log-header'>
            <div>Authorized Personnel</div>
            <div>Student Name</div>
            <div>Program</div>
            <div>Emergency Type</div>
            <div>Date</div>
            <div>Time</div>
            <div>Status</div>
            <div>Action</div>
          </div>";

    while ($row = $result->fetch_assoc()) {
        echo "<div class='log-row'>
                <div>" . htmlspecialchars($row['actor']) . "</div>
                <div>" . htmlspecialchars($row['student_name']) . "</div>
                <div>" . htmlspecialchars($row['program']) . "</div>
                <div>" . htmlspecialchars($row['emergency_type']) . "</div>
                <div>" . htmlspecialchars($row['date']) . "</div>
                <div>" . htmlspecialchars($row['time']) . "</div>
                <div>" . htmlspecialchars($row['status']) . "</div>
                <div>
                    <form action='update_log.php' method='GET'>
                        <input type='hidden' name='log_id' value='" . htmlspecialchars($row['id']) . "'>
                        <button type='submit' class='update-button'>Update</button>
                    </form>
                </div>
              </div>";
    }
} else {
    echo "<p>No logs found!</p>";
}

$conn->close();
