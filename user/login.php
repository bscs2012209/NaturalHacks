<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['is_user'] === 'user') {
    header("Location: index.php");
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        require_once "../connection.php";
        
        // Escape user inputs to prevent SQL injection
        $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
        $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        }
        
        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
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
                $errors['error'] = "Password does not match";
            }
        } else {
            $errors['error'] = "Email does not exist";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<?php
$css_path = '../assets/css/login.css';
$page_title = 'Login';

include('../layout/head.php');
?>

<body style="background-image: url('../assets/images/background.jpg');">


    <div class="wrapper">
        <div class="form-box login">
            <h2>Login</h2>
            <form action="./login.php" method="post">
                <span class="error"><?= $errors['error'] ?? ''?></span>
                <div class="input-box">
                    <span class="icon"> <img src="../assets/images/userb.png" width="20"></span>
                    <input type="email" name="email" id="email" onfocus="inputFocus('email-label', this)" onfocusout="inputFocusOut('email-label', this)">
                    <?php if(!empty($errors['email'])){ ?>
                    <span class="error"><?= $errors['email'] ?? '' ?></span>
                   <?php } ?> 
                    <label class="email-label">Email</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <img src="../assets/images/lockb.png" width="20">
                    </span>
                    <input type="password" name="password" id="password"  onfocus="inputFocus('password-label', this)" onfocusout="inputFocusOut('password-label', this)">
                    <?php if(!empty($errors['password'])){ ?>
                    <span class="error"><?= $errors['password'] ?? '' ?></span>
                   <?php } ?>
                    <label class="password-label">Password</label>
                </div>
                <div class="remember-forgot">
                    <a href="./forgot_password.php">Forgot Password?</a>
                </div>
                <button type="submit" name="submit" class="btn" id="loginBtn" >Login</button>
                <div class="login-register">
                    <p>Don't have an account?<a href="./register.php"> Register</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
    function inputFocus(className, event = ""){
        let inputLabel = document.getElementsByClassName(className)[0];
        inputLabel.style.top = '-5px';
    }

    function inputFocusOut(className, event = ""){
        if(event.value.length == 0){
        let inputLabel = document.getElementsByClassName(className)[0];
        inputLabel.style.top = '50%';
        }
    }
</script>

</body>

</html>
