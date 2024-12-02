<?php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "student_tracking";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchQuery = isset($_POST['searchQuery']) ? $_POST['searchQuery'] : '';
$section = isset($_POST['section']) ? $_POST['section'] : '';
$yearLevel = isset($_POST['yearLevel']) ? $_POST['yearLevel'] : '';
$program = isset($_POST['program']) ? $_POST['program'] : '';

$sql = "SELECT student_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name, section, year_level, program FROM student WHERE 1=1";

if ($searchQuery) {
    $sql .= " AND (student_id LIKE ? OR first_name LIKE ? OR middle_name LIKE ? OR last_name LIKE ?)";
}

if ($section) {
    $sql .= " AND section LIKE ?";
}
if ($yearLevel) {
    $sql .= " AND year_level LIKE ?";
}
if ($program) {
    $sql .= " AND program LIKE ?";
}

$stmt = $conn->prepare($sql);

$params = [];
$types = '';

if ($searchQuery) {
    $searchTerm = "%$searchQuery%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    $types .= 'ssss';
}
if ($section) {
    $params[] = "%$section%";
    $types .= 's';
}
if ($yearLevel) {
    $params[] = "%$yearLevel%";
    $types .= 's';
}
if ($program) {
    $params[] = "%$program%";
    $types .= 's';
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['section']}</td>
                <td>{$row['year_level']}</td>
                <td>{$row['program']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>No results found</td></tr>";
}

$stmt->close();
$conn->close();
