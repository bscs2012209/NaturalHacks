<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['is_user'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

require_once '../../connection.php';

$errors = [];
$user = [];

// Fetch user data
$selectSql = "SELECT * FROM `users` WHERE `id` = " . $_SESSION['user_id'];
$result = mysqli_query($conn, $selectSql);
$user = mysqli_fetch_assoc($result);

// Profile update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $image = $_SESSION['user_image'];

    // Validate fields
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email address';
    }
    if (empty($phone) || strlen($phone) < 11) {
        $errors['phone'] = 'Invalid phone number';
    }
    if (empty($address)) {
        $errors['address'] = 'Address is required';
    }

    // If there are no validation errors, proceed with the database update
    if (empty($errors)) {
        // Database update code for profile...
        $query = "UPDATE `users` SET `name` = '$name', `email` = '$email', `phone` = '$phone', `address` = '$address' WHERE `id` = " . $_SESSION['user_id'];
        $result = mysqli_query($conn, $query);

        // Process image upload
        if (!empty($_FILES['image']['name'])) {
            $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/FypProject/assets/uploaded_images/users/';
            $imageName = str_replace([' ', ':'], '-', time() . '_' . basename($_FILES['image']['name']));
            $imageMove = $uploadDirectory . $imageName;
            $imagePath = $_SERVER['HTTP_ORIGIN'] . '/FypProject/assets/uploaded_images/users/' . $imageName;

            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $imageMove)) {
                $image = $imagePath;
            } else {
                $errors['image'] = 'Failed to upload image';
            }
        } else {
            // No new image uploaded, retain the existing image path
            $image = $_SESSION['user_image'];
        }

        if ($result) {
            // Update session data if database update is successful
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_phone'] = $phone;
            $_SESSION['user_image'] = $image;

            header("Location: ./profile_update.php");
            exit();
        } else {
            $errors['database'] = 'Failed to update data into the database';
        }
    }
}

// Password change form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $currentPassword = mysqli_real_escape_string($conn, $_POST['current_password'] ?? '');
    $newPassword = mysqli_real_escape_string($conn, $_POST['new_password'] ?? '');
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password'] ?? '');

    // Validate fields
    if (empty($currentPassword)) {
        $errors['current_password'] = 'Current password is required';
    } elseif (!password_verify($currentPassword, $_SESSION['user_password'])) {
        $errors['current_password'] = 'Incorrect current password';
    }
    if (empty($newPassword) || strlen($newPassword) < 8) {
        $errors['new_password'] = 'New password must be at least 8 characters long';
    }
    if ($newPassword !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    // If there are no validation errors, proceed with the password update
    if (empty($errors)) {
        // Database update code for password...
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE `users` SET `password` = '$newPasswordHash' WHERE `id` = " . $_SESSION['user_id'];
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Update session data if database update is successful
            $_SESSION['user_password'] = $newPasswordHash;

            header("Location: ./profile_update.php");
            exit();
        } else {
            $errors['database'] = 'Failed to update data into the database';
        }
    }
}

$page_title = 'Profile Update';
include('../layout/head.php');
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <input type="checkbox" id="menu-toggle">
    <?php include('../layout/sidebar.php'); ?>

    <div class="main-content">
        <?php include('../layout/header.php'); ?>

        <main>
            <div class="page-content">
                <div class="card">
                    <h2 class="page-heading">Update Profile</h2>
                    <form class="page-form" action="profile_update.php" method="POST" enctype="multipart/form-data">
                        <!-- Profile update form fields -->
                        <fieldset>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>">
                            <span class="error"><?= $errors['name'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset>
                            <label for="email">Email:</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                            <span class="error"><?= $errors['email'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset>
                            <label for="phone">Phone:</label>
                            <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                            <span class="error"><?= $errors['phone'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset>
                            <label for="address">Address:</label>
                            <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                            <span class="error"><?= $errors['address'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset>
                            <label for="image">Image:</label>
                            <input type="file" name="image">
                            <img src="<?= htmlspecialchars($user['image']) ?>" width="100%" style="height: 5rem; width: 5rem;" alt="">
                            <span class="error"><?= $errors['image'] ?? ''; ?></span>
                        </fieldset>

                        <input type="submit" name="update_profile" class="form-submit" value="Update Profile">
                    </form>
                </div>

                <div class="card">
                    <h2 class="page-heading">Change Password</h2>
                    <form class="page-form" action="profile_update.php" method="POST">
                        <!-- Password change form fields -->
                        <fieldset>
                            <label for="current_password">Current Password:</label>
                            <input type="password" name="current_password">
                            <span class="error"><?= $errors['current_password'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset>
                            <label for="new_password">New Password:</label>
                            <input type="password" name="new_password">
                            <span class="error"><?= $errors['new_password'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset>
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" name="confirm_password">
                            <span class="error"><?= $errors['confirm_password'] ?? ''; ?></span>
                        </fieldset>
                        <input type="submit" name="change_password" class="form-submit" value="Change Password">
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
