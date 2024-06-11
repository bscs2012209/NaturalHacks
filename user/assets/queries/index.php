<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['is_user'] !== 'user') {
    header("Location: ./login.php");
    exit();
}

include('../../connection.php'); 

$userId = $_SESSION['user_id'] ?? null;

$sql = "SELECT COUNT(id) AS order_count FROM orders WHERE user_id = $userId";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    die("Error in query: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$userOrderCount = $row['order_count'];

mysqli_close($conn);
