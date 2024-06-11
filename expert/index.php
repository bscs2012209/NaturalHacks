<?php
session_start();
require_once '../connection.php';

if (!isset($_SESSION['expert_id']) || $_SESSION['is_expert'] !== 'expert') {
    header("Location: login.php");
    exit();
} else {
    header("Location: ./dashboard");
    exit(); 
}
?>
