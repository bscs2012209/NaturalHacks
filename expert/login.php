<?php
session_start();
if (isset($_SESSION['expert_id']) && $_SESSION['is_expert'] === 'expert') {
    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $errors = [];

        if (empty($email)) {
            $errors['email'] = "Email is required!";
        }

        if (empty($password)) {
            $errors['password'] = "Password is required!";
        }

        require_once "../connection.php";
        $sql = "SELECT * FROM experts WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $expert = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($expert) {
            if (password_verify($_POST['password'], $expert['password'])) {
                session_start();
                $_SESSION['expert_id'] = $expert['id'];
                $_SESSION['expert_name'] = $expert['name'];
                $_SESSION['expert_email'] = $expert['email'];
                $_SESSION['expert_image'] = $expert['image'];
                $_SESSION['is_expert'] = 'expert';
                header("Location: index.php");
                die();
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

<body style="background-image: url('../assets/images/background.jpg');"">
        <div class="wrapper">
        <div class="form-box login">
            <h2>Expert Login</h2>
            <span class="error"><?= $errors['error'] ?? '' ?></span>
            <form action="./login.php" method="post">
                <div class="input-box">
                    <span class="icon"> <img src="../assets/images/userb.png" width="20"></span>
                    <input type="email" name="email" id="email" onfocus="inputFocus('email-label', this)" onfocusout="inputFocusOut('email-label', this)">
                    <span class="error"><?= $errors['email'] ?? ''?></span>
                    <label class="email-label">Email</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <img src="../assets/images/lockb.png" width="20">
                    </span>
                    <input type="password" name="password" id="password"  onfocus="inputFocus('password-label', this)" onfocusout="inputFocusOut('password-label', this)">
                    <span class="error"><?= $errors['password'] ?? ''?></span>
                    <label class="password-label">Password</label>
                </div>
                <button type="submit" name="submit" class="btn" id="loginBtn" >Login</button>
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

