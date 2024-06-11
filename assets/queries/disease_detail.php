<?php
require_once './connection.php';

session_start();

$id = isset ($_GET['id']) ? $_GET['id'] : die ('Invalid ID');

$sql = "SELECT * FROM diseases WHERE id=$id";
$detail = mysqli_query($conn, $sql);

if (!$detail) {
    die ('Error retrieving remedy details: ' . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($detail);

if (!$data) {
    die ('Disease not found');
}

$remediesQuery = "SELECT * FROM remedies WHERE disease_id = $id AND expert_approval = 'approved'";
$remediesResult = mysqli_query($conn, $remediesQuery);
$remedies = mysqli_fetch_all($remediesResult, MYSQLI_ASSOC);

$discount = null;
$currentDate = date('Y-m-d');

$query = "SELECT * FROM `discounts` WHERE `start_date` <= '$currentDate' AND `end_date` >= '$currentDate' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $discount = mysqli_fetch_assoc($result);
}

function checkDiscount($amount, $discount) {
    if ($discount['type'] == 'flat') {
        $discountedAmount = $amount - $discount['discount'];
        return $discountedAmount > 0 ? $discountedAmount : 0;
    } else if ($discount['type'] == 'percent') {
        $discountAmount = $amount * ($discount['discount'] / 100);
        $discountedAmount = $amount - $discountAmount;
        return $discountedAmount > 0 ? $discountedAmount : 0;
    } else {
        return $amount;
    }
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


$header_icon = [
    'search' => true,
    'cart' => true,
];