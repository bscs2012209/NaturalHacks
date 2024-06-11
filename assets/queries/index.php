<?php

require_once './connection.php';

include('./assets/queries/helpers/get_remedy_detail.php');

session_start();

$results = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset ($_POST['search_query'])) {
        $search_query = $_POST['search_query'];

        $search_query = mysqli_real_escape_string($conn, $search_query);

        $sql = "SELECT id, name, image FROM diseases WHERE name LIKE '%" . $search_query . "%'
                UNION ALL
                SELECT id, name, images FROM remedies WHERE featured = '0' AND name LIKE '%" . $search_query . "%'";

        $result = mysqli_query($conn, $sql);
        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
       
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($results);
        exit;
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

$loggedIn = isset ($_SESSION['is_user']);

if ($loggedIn) {
    $navbarItems[] = ['label' => $_SESSION['user_name'], 'url' => './user/index.php'];
    $navbarItems[] = ['label' => 'Log Out', 'url' => './user/logout.php'];
} else {
    $navbarItems[] = ['label' => 'Login', 'url' => './user/login.php'];
}
//End::Navbar Items


$diseaseQuery = "SELECT * FROM diseases LIMIT 6";
$diseasesResult = mysqli_query($conn, $diseaseQuery);
$diseases = mysqli_fetch_all($diseasesResult, MYSQLI_ASSOC);

$remedyQuery = "SELECT * FROM remedies WHERE featured = 1 LIMIT 6";
$remediesResult = mysqli_query($conn, $remedyQuery);
$remedies = mysqli_fetch_all($remediesResult, MYSQLI_ASSOC);

$header_icon = [
    'search' => true,
    'cart' => true,
];





$orderItemsGrouped = array();

$orderItemQuery = "SELECT `order_id`, `remedy_id` FROM `order_items`";
$orderItemResult = mysqli_query($conn, $orderItemQuery);

while ($row = mysqli_fetch_assoc($orderItemResult)) {
    $orderId = $row['order_id'];
    $remedyId = $row['remedy_id'];
    
    if (!isset($orderItemsGrouped[$orderId])) {
        $orderItemsGrouped[$orderId] = array();
    }
    
    $orderItemsGrouped[$orderId][] = $remedyId;
}

$orderItemsGrouped = array_values($orderItemsGrouped);

$dataset_json = json_encode($orderItemsGrouped);



include('./python/apriori.php');

