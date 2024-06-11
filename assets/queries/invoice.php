<?php

require_once './connection.php';
// include('./helpers/get_remedy_detail.php');
session_start();

$id = isset($_GET['id']) ? $_GET['id'] : die('Invalid ID');
$user_id = $_SESSION['user_id'];

$sql_user = "SELECT * FROM users WHERE id = $user_id";
$result_user = mysqli_query($conn, $sql_user);
$user = mysqli_fetch_assoc($result_user);

$sql_order = "SELECT * 
              FROM orders 
              WHERE id = '$id'";

$result_order = mysqli_query($conn, $sql_order);
$order = mysqli_fetch_assoc($result_order);

$sql_order_items = "SELECT * FROM order_items  WHERE order_id = '$id'";

$result_order_items = mysqli_query($conn, $sql_order_items);

$order_items = [];
while ($row = mysqli_fetch_assoc($result_order_items)) {
    $order_items[] = $row;
}

function getRemedyDetail($id, $connection)
{
    $remedy_name_sql = "SELECT * FROM remedies WHERE id = '$id' AND expert_approval = 'approved'";
    $remedy_name_detail = mysqli_query($connection, $remedy_name_sql);
    return mysqli_fetch_assoc($remedy_name_detail);
}

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


//Begin::Navbar Items
$navbarItems = [
    ['label' => 'Home', 'url' => './index.php'],
    ['label' => 'Herbs', 'url' => './index.php#remedy'],
    ['label' => 'About', 'url' => './index.php#about'],
    ['label' => 'Disease', 'url' => './index.php#categories'],
    ['label' => 'Stores', 'url' => './stores.php'],
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
