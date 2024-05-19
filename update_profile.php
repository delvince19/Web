<?php
session_start();
include("config.php");

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['student_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $remove_image = isset($_POST['remove_image']) ? true : false;
    $profile_picture = '';

    if ($remove_image) {
        $profile_picture = 'img/default_pfp.png';
    } else if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $uploaded_file = $upload_dir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploaded_file)) {
            $profile_picture = $uploaded_file;
        }
    } else {
        $profile_picture = $_POST['existing_picture'];
    }

    $query = "UPDATE tbl_users SET firstname=?, middlename=?, lastname=?, email=?, profile_picture=? WHERE student_id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('sssssi', $firstname, $middlename, $lastname, $email, $profile_picture, $student_id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['firstname'] = $firstname;
    $_SESSION['middlename'] = $middlename;
    $_SESSION['lastname'] = $lastname;
    header('Location: profile.php?success=1');
    exit();
}

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
    <title>Profile Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Update Profile</h2>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Profile updated successfully!</div>
    <?php endif; ?>
    <form action="profile.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?= htmlspecialchars($firstname) ?>" required>
        </div>
        <div class="mb-3">
            <label for="middlename" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middlename" name="middlename" value="<?= htmlspecialchars($middlename) ?>" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?= htmlspecialchars($lastname) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <div class="profile-img-container mb-3">
                <img src="<?= htmlspecialchars($profile_picture) ?>" alt="Profile Picture" style="width: 100px; height: 100px;">
            </div>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
            <input type="hidden" name="existing_picture" value="<?= htmlspecialchars($profile_picture) ?>">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remove_image" name="remove_image">
            <label class="form-check-label" for="remove_image">Remove current image and use default</label>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
