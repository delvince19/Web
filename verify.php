<?php
session_start();

if (!isset($_SESSION['verification_code']) || !isset($_SESSION['email'])) {
    // Redirect to registration page if verification code or email is not set in session
    header("Location: register.php");
    exit();
}

if (isset($_POST['verifyButton'])) {
    $entered_code = $_POST['verification_code'];
    $stored_code = $_SESSION['verification_code'];
    $email = $_SESSION['email'];

    if ($entered_code == $stored_code) {
        // Code matches, complete registration process
        // Insert user details into the database
        // Clear session variables
        unset($_SESSION['verification_code']);
        unset($_SESSION['email']);
        // Redirect to success page or login page
        header("Location: registration_success.php");
        exit();
    } else {
        // Code does not match, display error message
        $error_message = "Invalid verification code. Please try again.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
</head>
<body>

<h1>Verify Your Email</h1>
<?php if (isset($error_message)) : ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php endif; ?>
<form action="" method="post">
    <label for="verification_code">Enter Verification Code:</label>
    <input type="text" id="verification_code" name="verification_code" required>
    <button type="submit" name="verifyButton">Verify</button>
</form>

</body>
</html>
