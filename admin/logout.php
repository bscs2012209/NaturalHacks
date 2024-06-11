<?php
session_start();
if (isset($_SESSION['admin_id']) || $_SESSION['is_admin'] === 'admin') {
    session_destroy();
}
header("Location: ./login.php");
exit();
?>
