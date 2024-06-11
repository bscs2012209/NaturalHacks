<?php
session_start();
if (isset($_SESSION['user_id']) || $_SESSION['is_user'] === 'user') {
    session_destroy();
}
header("Location: ./login.php");
exit();
?>
