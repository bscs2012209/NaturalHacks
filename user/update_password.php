<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);

    // Validate the token and OTP
    $query = "SELECT user_id FROM forget_passwords WHERE token = '$token' AND otp = '$otp' AND expired = 0";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's password
        $update_query = "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'";
        if (mysqli_query($conn, $update_query)) {
            // Mark the token as expired
            $expire_query = "UPDATE forget_passwords SET expired = 1 WHERE token = '$token'";
            mysqli_query($conn, $expire_query);

            echo "Your password has been successfully updated.";
        } else {
            echo "Failed to update the password.";
        }
    } else {
        echo "Invalid OTP or token.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
</head>
<body>
<form action="update_password.php" method="POST">
    <fieldset>
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']); ?>">
        <label for="otp">OTP</label>
        <input type="text" name="otp" required>
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" required>
        <button type="submit">Update Password</button>
    </fieldset>
</form>
</body>
</html>
