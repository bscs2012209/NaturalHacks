<?php
require_once './connection.php';

session_start();

$id = isset ($_GET['id']) ? $_GET['id'] : die ('Invalid ID');

$sql = "SELECT * FROM remedies WHERE id= $id AND expert_approval = 'approved'";
$detail = mysqli_query($conn, $sql);

if (!$detail) {
    die ('Error retrieving remedy details: ' . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($detail);

if (!$data) {
    die ('Remedy not found');
}


$navbarItems = [
    ['label' => 'Home', 'url' => './index.php'],
    ['label' => 'Herbs', 'url' => './index.php#remedy'],
    ['label' => 'About', 'url' => './index.php#about'],
    ['label' => 'Disease', 'url' => './index.php#categories'],
    ['label' => 'Stores', 'url' => './stores.php'],
];

$loggedIn = isset ($_SESSION['is_user']);

if ($loggedIn) {
    $navbarItems[] = ['label' => $_SESSION['user_name'], 'url' => './user/index.php'];
    $navbarItems[] = ['label' => 'Log Out', 'url' => './user/logout.php'];
} else {
    $navbarItems[] = ['label' => 'Login', 'url' => './user/login.php'];
}

$images = json_decode($data['images']);

$header_icon = [
    'search' => true,
    'cart' => true,
];
