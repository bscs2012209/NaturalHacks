<?php
// Include database connection file
require '../connection.php';

// Include PHPMailer files
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email from the form
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Validate the email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Check if the email exists in the users table
    $query = "SELECT `id`, `name`, `email` FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];

        $otp = rand(100000, 999999);
        $token = bin2hex(random_bytes(16));

        // Insert the token into the forget_passwords table
        $insert_query = "INSERT INTO forget_passwords (user_id, token, otp, expired) VALUES ('$user_id', '$token', '$otp', 0)";
        if (mysqli_query($conn, $insert_query)) {

            // Fetch the OTP from the database
            $otp_query = "SELECT otp FROM forget_passwords WHERE token = '$token'";
            $otp_result = mysqli_query($conn, $otp_query);
            if (mysqli_num_rows($otp_result) > 0) {
                $otp_row = mysqli_fetch_assoc($otp_result);
                $fetched_otp = $otp_row['otp'];

                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'kashafkhalid65@gmail.com';
                    $mail->Password   = 'avzs frub cqbj jdpv';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    // Recipients
                    $mail->setFrom('kashafkhalid65@gmail.com', 'Natural Hacks');
                    $mail->addAddress($row['email'], $row['name']);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Request';
                    $mail->Body    = "
                        <html>
                        <head>
                            <style>
                                .email-container {
                                    font-family: Arial, sans-serif;
                                    line-height: 1.6;
                                    color: #333333;
                                    padding: 20px;
                                    border: 1px solid #dddddd;
                                    border-radius: 5px;
                                    background-color: #f9f9f9;
                                }
                                .email-header {
                                    font-size: 24px;
                                    margin-bottom: 20px;
                                    color: #4CAF50;
                                }
                                .email-body {
                                    margin-bottom: 20px;
                                }
                                .email-footer {
                                    margin-top: 20px;
                                    font-size: 12px;
                                    color: #777777;
                                }
                                .reset-link {
                                    display: inline-block;
                                    padding: 10px 20px;
                                    font-size: 16px;
                                    color: #ffffff;
                                    background-color: #4CAF50;
                                    text-decoration: none;
                                    border-radius: 5px;
                                }
                            </style>
                        </head>
                        <body>
                            <div class='email-container'>
                                <div class='email-header'>Password Reset Request</div>
                                <div class='email-body'>
                                    <p>Dear {$row['name']},</p>
                                    <p>We received a request to reset your password. Please click the button below to reset your password:</p>
                                    <p><a class='reset-link' href='https://naturalhacks.is-great.net/user/update_password.php?token=$token'>Reset Password</a></p>
                                    <p>Your OTP for password reset is: <strong>{$fetched_otp}</strong></p>
                                    <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
                                </div>
                                <div class='email-footer'>
                                    <p>Thank you,<br>Natural Hacks Team</p>
                                </div>
                            </div>
                        </body>
                        </html>";
                    $mail->AltBody = 'Dear ' . $row['name'] . ', We received a request to reset your password. Please copy and paste this link into your browser to reset your password: https://naturalhacks.is-great.net/user/update_password.php?token=' . $token . ' Your OTP for password reset is: ' . $fetched_otp . ' If you did not request a password reset, please ignore this email or contact support if you have questions. Thank you, Natural Hacks Team';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Failed to fetch the OTP.";
            }
        } else {
            echo "Failed to insert the record.";
        }
    } else {
        echo "Email does not exist.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
$css_path = '../assets/css/login.css';
$page_title = 'Login';

include('../layout/head.php');
?>

<body style="background-image: url('../assets/images/background.jpg');">


<div class="wrapper">
    <div class="form-box login">
        <h2>Forgot Password</h2>
        
    <form action="forgot_password.php" method="POST">

        <div class="input-box">
            <span class="icon"> <img src="../assets/images/userb.png" width="20"></span>
            <input type="email" name="email" id="email" onfocus="inputFocus('email-label', this)" onfocusout="inputFocusOut('email-label', this)">
            <label class="email-label">Email</label>
            <?php if(!empty($errors['email'])){ ?>
            <span class="error"><?= $errors['email'] ?? '' ?></span>
            <?php } ?> 
        </div>

        <button type="submit" name="submit" class="btn" id="submitBtn" >Submit</button>
                
    </form>
    </div>
</div>
</body>
</html>
