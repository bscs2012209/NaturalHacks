<?php 
require_once './connection.php';

session_start();

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


$diseaseQuery = "SELECT * FROM diseases";
$diseasesResult = mysqli_query($conn, $diseaseQuery);
$diseases = mysqli_fetch_all($diseasesResult, MYSQLI_ASSOC);

$header_icon = [
    'search' => true,
    'cart' => true,
];

// include('./assets/queries/cart.php');
