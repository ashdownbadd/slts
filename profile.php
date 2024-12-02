<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: signin.html");
    exit();
}

$username = $_SESSION['username'];
$last_name = $_SESSION['last_name'];
$first_name = $_SESSION['first_name'];
$middle_name = $_SESSION['middle_name'];
$extension = $_SESSION['extension'];
$mobile_no = $_SESSION['mobile_no'];
$email = $_SESSION['email'];
$year_level = $_SESSION['year_level'];
$section = $_SESSION['section'];
$program = $_SESSION['program'];
$student_id = $_SESSION['student_id'];
$emergency_no = $_SESSION['emergency_no'];
$emergency_name = $_SESSION['emergency_name'];

date_default_timezone_set('Asia/Manila');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="icon_planet.jpg">
    <link rel="stylesheet" href="profile.css">
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card__border">
                <img src="icon.jpg" alt="card image" class="card__img">
            </div>

            <h3 class="card__name">
                <?php
                echo htmlspecialchars($_SESSION['first_name']) . ' ' .
                    htmlspecialchars($_SESSION['middle_name']) . ' ' .
                    htmlspecialchars($last_name);
                ?>
            </h3>

            <span class="card__profession"><?php echo htmlspecialchars($program); ?></span>

            <div class="card__social" id="card-social">
                <div class="card__social-control">
                    <div class="card__social-toggle" id="card-toggle">
                        <i class="ri-add-line"></i>
                    </div>
                    <span class="card__social-text">See More</span>
                    <ul class="card__social-list">
                        <a href="updateform.html?last_name=<?php echo urlencode($last_name); ?>&first_name=<?php echo urlencode($first_name); ?>&middle_name=<?php echo urlencode($middle_name); ?>&extension=<?php echo urlencode($extension); ?>&mobile_no=<?php echo urlencode($mobile_no); ?>&email=<?php echo urlencode($email); ?>&year_level=<?php echo urlencode($year_level); ?>&section=<?php echo urlencode($section); ?>&program=<?php echo urlencode($program); ?>&student_id=<?php echo urlencode($student_id); ?>&emergency_no=<?php echo urlencode($emergency_no); ?>&emergency_name=<?php echo urlencode($emergency_name);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ?>" class="card__social-link pen-icon">
                            <div class="circle">
                                <i class="fa fa-pen"></i>
                            </div>
                        </a>

                        <a href="manualguide.html" class="card__social-link" id="settings">
                            <i class="fas fa-sticky-note"></i>
                        </a>
                        <a href="logout.php" class="card__social-link">
                            <i class="fas fa-power-off"></i>
                        </a>
                    </ul>
                </div>
            </div>
        </div>

        <div class="emergency-buttons">
            <h4>TYPE OF EMERGENCY</h4>

            <div class="button-container">
                <div class="button-row">
                    <button class="emergency-button" id="medicalEmergency" title="Medical Emergency" data-emergency-type="Medical Emergency">
                        <i class="fas fa-heartbeat"></i>
                    </button>

                    <button class="emergency-button" id="violenceEmergency" title="Violence Emergency" data-emergency-type="Violence Emergency">
                        <i class="fas fa-hand-rock"></i>
                    </button>

                    <button class="emergency-button" id="fireEmergency" title="Fire Emergency" data-emergency-type="Fire Emergency">
                        <i class="fas fa-fire"></i>
                    </button>
                </div>

                <div class="button-row">
                    <button class="emergency-button" id="security" title="Security Threat" data-emergency-type="Security Threat">
                        <i class="fas fa-shield-alt"></i>
                    </button>

                    <button class="emergency-button" id="powerOutage" title="Power Outage" data-emergency-type="Power Outage">
                        <i class="fas fa-bolt"></i>
                    </button>

                    <button class="emergency-button" id="stranded" title="Stranded" data-emergency-type="Stranded">
                        <i class="fas fa-map-marker"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="emergencyModal" class="alert-modal" style="display: none;">
            <div class="alert-container">
                <h2 class="alert-title">Alert Activation Confirmation</h2>
                <p class="alert-message">Are you sure you want to send an emergency alert?</p>
                <button id="uploadButton" class="alert-button"><i class="fas fa-camera"></i></button>
                <input type="file" id="fileInput" class="file-input" accept="image/*" style="display: none;">

                <div id="imagePreviewContainer" style="display: none;">
                    <h5>Preview</h5>
                    <img id="imagePreview" src="" alt="Image Preview" style="max-width: 100%; max-height: 300px; border: 1px solid #ddd; margin-top: 10px;">
                </div>

                <video id="video" class="video-preview" autoplay style="display: none;"></video>
                <canvas id="canvas" class="photo-canvas" style="display: none;"></canvas>

                <button id="confirmButton" class="alert-button confirm-button">Confirm</button>
                <button id="cancelButton" class="alert-button cancel-button">Cancel</button>
            </div>
        </div>


        <div id="noticeModal" class="modals">
            <div class="modal-contents">
                <h2>Important Notice</h2>
                <br>
                <p>Please, read this carefully:</p>
                <br>
                <p>Using the emergency buttons is a serious matter. Pranking or joking around with these buttons will have corresponding punishments. We rely on these alerts to ensure everyone's safety, and misuse can lead to unnecessary panic and resource allocation. Please use them responsibly.</p>
                <br>
                <button id="understoodButton" class="modal-button">Understood</button>
                <br>
                <label>
                    <input type="checkbox" id="dontShowAgainCheckbox">
                    Don't show this again.
                </label>
            </div>
        </div>
    </div>

    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <span class="close" id="modalClose">&times;</span>
            <h2>Sign Out</h2>
            <p>Are you sure you want to logout?</p>
            <button id="confirmLogout">Yes</button>
            <button id="cancelLogout">Cancel</button>
        </div>
    </div>

    <?php
    $current_hour = date("H");

    if ($current_hour < 12) {
        $greeting = "Good Morning";
    } elseif ($current_hour < 18) {
        $greeting = "Good Afternoon";
    } else {
        $greeting = "Good Evening";
    }

    $last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : 'Student';

    echo "<h1><span class='greeting'>$greeting, </span><span class='name'>" . strtoupper(htmlspecialchars($first_name)) . "</span></h1>";
    ?>

    <script src="profile.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let locationAllowed = false;
            let watchId = null;

            function requestLocationPermission() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            locationAllowed = true;
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;
                            sendLocationToServer(latitude, longitude, true);
                            watchId = navigator.geolocation.watchPosition(updatePosition, handleError, {
                                enableHighAccuracy: true,
                                maximumAge: 30000,
                                timeout: 27000
                            });
                        },
                        (error) => {
                            if (error.code === error.PERMISSION_DENIED) {
                                sendLocationToServer(null, null, false);
                            } else {
                                console.error("Geolocation error:", error);
                            }
                        }
                    );
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }

            function updatePosition(position) {
                if (locationAllowed) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    sendLocationToServer(latitude, longitude, true);
                }
            }

            function handleError(error) {
                console.error("Geolocation error:", error);
            }

            requestLocationPermission();

            window.addEventListener('beforeunload', () => {
                if (watchId !== null) {
                    navigator.geolocation.clearWatch(watchId);
                }
            });
        });

        function sendEmergencyAlert(emergencyType) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "send_alert.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            const data = `emergency_type=${encodeURIComponent(emergencyType)}`;
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send(data);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const noticeModal = document.getElementById('noticeModal');
            const dontShowAgainCheckbox = document.getElementById('dontShowAgainCheckbox');

            if (localStorage.getItem('dontShowNotice') !== 'true') {
                noticeModal.style.display = 'block';
            }

            if (localStorage.getItem('dontShowAgainChecked') === 'true') {
                dontShowAgainCheckbox.checked = true;
            }

            document.getElementById('understoodButton').addEventListener('click', () => {
                localStorage.setItem('dontShowNotice', dontShowAgainCheckbox.checked);
                localStorage.setItem('dontShowAgainChecked', dontShowAgainCheckbox.checked);
                closeModal();
            });
        });

        function closeModal() {
            const noticeModal = document.getElementById('noticeModal');
            noticeModal.style.display = 'none';
        }

        const ws = new WebSocket('ws://192.168.0.101:8080');

        document.addEventListener('DOMContentLoaded', () => {
            const emergencyModal = document.getElementById('emergencyModal');
            const confirmButton = document.getElementById('confirmButton');
            const cancelButton = document.getElementById('cancelButton');
            const uploadButton = document.getElementById('uploadButton');
            const fileInput = document.getElementById('fileInput');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            let emergencyType = "";
            let photoData = null;

            function resetModal() {
                photoData = null;
                imagePreviewContainer.style.display = 'none';
                imagePreview.src = "";
                fileInput.value = "";
            }

            document.querySelectorAll('.emergency-button').forEach(button => {
                button.addEventListener('click', () => {
                    emergencyType = button.getAttribute('title');

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition((position) => {
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;

                            window.currentLatitude = latitude;
                            window.currentLongitude = longitude;

                            resetModal();
                            emergencyModal.style.display = 'block';
                        }, () => {
                            alert("Location access is required for emergency alerts.");
                        });
                    } else {
                        alert("Geolocation is not supported by this browser.");
                    }
                });
            });

            uploadButton.addEventListener('click', () => {
                const options = confirm('Choose an option:\n1. Upload image from file (Press OK)\n2. Take a photo (Press Cancel)');
                if (options) {
                    fileInput.click();
                } else {
                    startVideo();
                }
            });

            fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                        photoData = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            function startVideo() {
                video.style.display = 'block';
                try {
                    const stream = navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    video.srcObject = stream;
                } catch (err) {
                    alert("Error accessing camera: " + err.message);
                }
            }

            video.addEventListener('click', () => {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                photoData = canvas.toDataURL('image/png');
                video.style.display = 'none';
                imagePreview.src = photoData;
                imagePreviewContainer.style.display = 'block';
            });

            confirmButton.addEventListener('click', () => {
                emergencyModal.style.display = 'none';
                triggerEmergency(emergencyType, photoData);
            });

            cancelButton.addEventListener('click', () => {
                emergencyModal.style.display = 'none';
                resetModal();
            });

            function triggerEmergency(emergencyType, photoData) {
                const formData = new FormData();
                formData.append("emergency_type", emergencyType);
                formData.append("latitude", window.currentLatitude);
                formData.append("longitude", window.currentLongitude);

                if (photoData) {
                    const photoFile = dataURItoBlob(photoData);
                    formData.append("photo", photoFile, "emergency_image.png");
                }

                const xhr = new XMLHttpRequest();
                xhr.open("POST", "send_alert.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert(xhr.responseText);
                    }
                };
                xhr.send(formData);

                if (ws.readyState === WebSocket.OPEN) {
                    const userData = {
                        student_id: "<?php echo $student_id; ?>",
                        last_name: "<?php echo $last_name; ?>",
                        first_name: "<?php echo $first_name; ?>",
                        middle_name: "<?php echo $middle_name; ?>",
                        extension: "<?php echo $extension; ?>",
                        mobile_no: "<?php echo $mobile_no; ?>",
                        email: "<?php echo $email; ?>",
                        year_level: "<?php echo $year_level; ?>",
                        section: "<?php echo $section; ?>",
                        program: "<?php echo $program; ?>",
                        emergency_no: "<?php echo $emergency_no; ?>",
                        emergency_name: "<?php echo $emergency_name; ?>",
                        emergencyType: emergencyType,
                        latitude: window.currentLatitude,
                        longitude: window.currentLongitude,
                    };
                    ws.send(JSON.stringify({
                        type: 'emergency',
                        ...userData
                    }));
                } else {
                    console.error("WebSocket connection is not open.");
                }
            }

            function dataURItoBlob(dataURI) {
                const byteString = atob(dataURI.split(',')[1]);
                const ab = new ArrayBuffer(byteString.length);
                const ia = new Uint8Array(ab);
                for (let i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }
                return new Blob([ab], {
                    type: 'image/png'
                });
            }
        });
    </script>
</body>

</html>