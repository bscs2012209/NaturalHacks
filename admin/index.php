<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: login.php");
} else {
    header("Location: ./dashboard");
}
?>
