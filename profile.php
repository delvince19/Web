<?php
session_start();
include("config.php");

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['student_id'];

$query = "SELECT firstname, middlename, lastname, email, profile_picture FROM tbl_users WHERE student_id=?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$stmt->bind_result($firstname, $middlename, $lastname, $email, $profile_picture);
$stmt->fetch();
$stmt->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-img-container {
            text-align: center;
        }
        .return-button {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="mb-3">
        <div class="profile-img-container mb-3" onclick="toggleOptions()">
            <img id="profile-picture" src="<?= htmlspecialchars($profile_picture) ?>" alt="Profile Picture" class="rounded-circle" style="width: 100px; height: 100px;">
            <div id="options" class="dropdown-menu" style="background-color: #fcb651">
                <ul class="proflogout mt-3">
                    <li class="prof fw-bold"><a href="#" onclick="changeProfilePicture()">Change Profile Picture</a></li>
                    <li class="logout fw-bold"><a href="#" onclick="removeProfilePicture()">Remove Profile Picture</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($firstname . ' ' . $middlename . ' ' . $lastname) ?>" readonly>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" value="<?= htmlspecialchars($email) ?>" readonly>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" value="*********" readonly>
    </div>
    <a href="index.php" class="btn btn-primary return-button">Return</a>
</div>

<script>
    function toggleOptions() {
        var options = document.getElementById('options');
        options.classList.toggle('dropdown-visible');
    }

    function changeProfilePicture() {
        // Implement your logic to change the profile picture
    }

    function removeProfilePicture() {
        // Implement your logic to remove the profile picture and set the default one
        document.getElementById('profile-picture').src = 'img/default_pfp.png';
    }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

