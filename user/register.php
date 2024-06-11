<?php
require_once '../connection.php';

$fullName = '';
$email = '';
$phoneNumber = '';
$password = '';
$confirmPassword = '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Process the form data here
        $fullName = isset($_POST['fullName']) ? mysqli_real_escape_string($conn, $_POST['fullName']) : '';
        $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
        $phoneNumber = isset($_POST['phoneNumber']) ? mysqli_real_escape_string($conn, $_POST['phoneNumber']) : '';
        $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
        $confirmPassword = isset($_POST['confirmPassword']) ? mysqli_real_escape_string($conn, $_POST['confirmPassword']) : '';

        if (empty($fullName)) {
            $errors['full_name'] = "Full Name is required";
        }

        if (empty($email)) {
            $errors['email'] =  "Email is required";
        }

        if (empty($phoneNumber)) {
            $errors['phone'] =  "Phone is required";
        }
        
        if (empty($password)) {
            $errors['password'] = "Password is required";
        }

        if (empty($confirmPassword)) {
            $errors['confirm_password'] = "Confirm password is required";
        }
        
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_valid'] = "Email must be a valid email address";
        }

        if (!empty($password) && strlen($password) < 8) {
            $errors['password_valid'] = "Password must be at least 8 characters";
        }

        if (!empty($confirmPassword) && $password !== $confirmPassword) {
            $errors['password_not_match'] = "Password does not match";
        }

        if (empty($errors)) {
            // If there are no errors, proceed with database insertion
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`name`, `password`, `email`, `phone`) VALUES ('$fullName', '$hashedPassword', '$email', '$phoneNumber')";
            $result = mysqli_query($conn, $sql);
        
            if ($result) {
                $userId = mysqli_insert_id($conn);
                $selectSql = "SELECT * FROM `users` WHERE `id` = $userId";
                $selectResult = mysqli_query($conn, $selectSql);
        
                if ($selectResult) {
                    $user = mysqli_fetch_assoc($selectResult);
        
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_phone'] = $user['phone'];
                    $_SESSION['user_image'] = $user['image'];
                    $_SESSION['user_password'] = $user['password'];
                    $_SESSION['is_user'] = 'user';
        
                    header("Location: ../index.php");
                    exit();
                } else {
                    $errors['error'] = "Error fetching user from the database";
                }
            } else {
                $errors['error'] = "Error inserting user into the database";
            }
        }
        
    }
}
?>


<!DOCTYPE html>
<html>

<?php
$css_path = '../assets/css/register.css';
$page_title = 'Register';

include('../layout/head.php');
?>

<body style="background-image: url('../assets/images/background.jpg');">
    
    <div class="wrapper">
        <div class="form-box login">
            <h2>Register</h2>
            <form action="register.php" method="post">    
                <span class="error"><?= $errors['error'] ?? '' ?></span>
                <div class="input-box">
                    <span class="icon"><img src="../assets/images/userb.png" width="20"></span>
                    <input type="text" name="fullName" id="fullName" value="<?= $fullName ?>">
                    <span class="error"><?= $errors['full_name'] ?? '' ?></span>
                    <label>Full Name</label>
                </div>
                <div class="input-box">
                    <span class="icon"><img src="../assets/images/email2.png" width="20"></span>
                    <input type="email" name="email" id="email" value="<?= $email ?>">
                    <span class="error"><?= $errors['email'] ?? '' ?></span>
                    <span class="error"><?= $errors['email_valid'] ?? '' ?></span>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><img src="../assets/images/phone.png" width="20"></span>
                    <input type="number" min="11" max="12" name="phoneNumber" id="phoneNumber" value="<?= $phoneNumber ?>">
                    <span class="error"><?= $errors['phone'] ?? '' ?></span>
                    <label>Phone Number</label>
                </div>
                <div class="input-box">
                    <span class="icon"><img src="../assets/images/lockb.png" width="20"></span>
                    <input type="password" name="password" id="password">
                    <span class="error"><?= $errors['password'] ?? '' ?></span>
                    <span class="error"><?= $errors['password_valid'] ?? '' ?></span>
                    <label>Password</label>
                </div>
                <div class="input-box">
                    <span class="icon"><img src="../assets/images/lockb.png" width="20"></span>
                    <input type="password" name="confirmPassword" id="confirmPassword">
                    <span class="error"><?= $errors['confirm_password'] ?? '' ?></span>
                    <span class="error"><?= $errors['password_not_match'] ?? '' ?></span>
                    <label>Re-enter Password</label>
                </div>
                <button type="submit" class="btn" name="submit" id="registerButton">Register</button>
            </form>
        </div>
    </div>
    <script type="module" src="register.js"></script>
</body>

</html>
