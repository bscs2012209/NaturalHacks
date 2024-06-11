<?php
session_start();
if (isset ($_SESSION['admin_id']) && $_SESSION['is_admin'] === 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset ($_POST['submit'])) {
        require_once "../connection.php";

        // Sanitize inputs using mysqli_real_escape_string
        $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
        $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';

        $errors = [];

        if (empty($email)) {
            $errors['email'] = "Email is required!";
        }

        if (empty($password)) {
            $errors['password'] = "Password is required!";
        }

        $sql = "SELECT * FROM admins WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $admin = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                session_start();
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_image'] = $admin['image'];
                $_SESSION['is_admin'] = 'admin';
                header("Location: index.php");
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

include ('../layout/head.php');
?>

<body style="background-image: url('../assets/images/background.jpg');"">
        <div class=" wrapper">
    <div class="form-box login">
        <h2>Admin Login</h2>
        <span class="error">
            <?= $errors['error'] ?? '' ?>
        </span>
        <form action="./login.php" method="post">
            <div class="input-box">
                <span class="icon"> <img src="../assets/images/userb.png" width="20"></span>
                <input type="email" name="email" id="email" onfocus="inputFocus('email-label', this)" onfocusout="inputFocusOut('email-label', this)">
                <span class="error">
                    <?= $errors['email'] ?? '' ?>
                </span>
                <label class="email-label">Email</label>
            </div>
            <div class="input-box">
                <span class="icon">
                    <img src="../assets/images/lockb.png" width="20">
                </span>
                <input type="password" name="password" id="password"  onfocus="inputFocus('password-label', this)" onfocusout="inputFocusOut('password-label', this)">
                 <span class="error">
                    <?= $errors['password'] ?? '' ?>
                </span>
                <label class="password-label">Password</label>
            </div>
            <button type="submit" name="submit" class="btn" id="loginBtn">Login</button>
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