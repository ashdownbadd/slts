<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request contains the expected variable
    if (isset($_POST['dontShowNotice'])) {
        $_SESSION['show_notice'] = $_POST['dontShowNotice'] === 'true' ? 'false' : 'true';
    }
}
?>
