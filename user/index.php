<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['is_user'] != 'user') {
    header("Location: login.php");
}else{
    header("Location: ./home/index.php");
}
