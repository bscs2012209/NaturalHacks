<?php

require_once './connection.php';

session_start();

$sql_stores = "SELECT * FROM stores";
$result_stores = mysqli_query($conn, $sql_stores);
$stores = [];
while ($row = mysqli_fetch_assoc($result_stores)) {
    $stores[] = $row;
}

//Begin::Navbar Items
$navbarItems = [
    ['label' => 'Home', 'url' => './index.php'],
    ['label' => 'Herbs', 'url' => './index.php#remedy'],
    ['label' => 'About', 'url' => './index.php#about'],
    ['label' => 'Disease', 'url' => './index.php#categories'],
];

$loggedIn = isset($_SESSION['is_user']);

if ($loggedIn) {
    $navbarItems[] = ['label' => $_SESSION['user_name'], 'url' => './user/index.php'];
    $navbarItems[] = ['label' => 'Log Out', 'url' => './user/logout.php'];
} else {
    $navbarItems[] = ['label' => 'Login', 'url' => './user/login.php'];
}
//End::Navbar Items

$header_icon = [
    'search' => true,
    'cart' => true,
];
