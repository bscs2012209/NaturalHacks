<?php
require_once './connection.php';

include('./assets/queries/helpers/get_remedy_detail.php');

session_start();

$id = isset($_GET['id']) ? $_GET['id'] : die('Invalid ID');
$user_id = $_SESSION['user_id'] ?? null;

$sql_detail = "SELECT * FROM remedies WHERE id = $id AND expert_approval = 'approved'";
$result_detail = mysqli_query($conn, $sql_detail);

if($user_id){
    $sql_rating = "SELECT * FROM reviews WHERE remedy_id = $id AND user_id = $user_id";
    $result_rating = mysqli_query($conn, $sql_rating);
}

if($user_id){
    $sql_reviews = "SELECT reviews.*, users.name AS `user_name`, users.image AS `user_image`
        FROM `reviews`
        INNER JOIN `users` ON reviews.user_id = users.id
        WHERE reviews.remedy_id = $id AND reviews.user_id != $user_id";
    $result_reviews = mysqli_query($conn, $sql_reviews);
}


if($user_id){
    if (!$result_detail || !$result_rating || !$result_reviews) {
        die('Error retrieving remedy details: ' . mysqli_error($conn));
    }
}else {
    if (!$result_detail) {
        die('Error retrieving remedy details: ' . mysqli_error($conn));
    }
}


$ratingStars = $ratingDescription = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ratingStars = $_POST['rating_stars'] ?? '';
    $ratingDescription = $_POST['rating_description'] ?? '';

    // Validate Rating Star
    if (empty($ratingStars)) {
        $errors['rating_stars'] = 'Rating Star is required.';
    }

    // Validate Rating Description
    if (empty($ratingDescription)) {
        $errors['rating_description'] = 'Rating Description is required.';
    }

    // If there are no validation errors, proceed with database insertion
    if (empty($errors)) {
        $insertSql = "INSERT INTO reviews (user_id, remedy_id, description, rating) VALUES ('$user_id', '$id', '$ratingDescription', '$ratingStars')";
        $response = mysqli_query($conn, $insertSql);


        $sql_avg_rating = "SELECT AVG(rating) AS average_rating FROM reviews WHERE remedy_id = $id";
        $result_rating = mysqli_query($conn, $sql_avg_rating);
        $average_rating_data = mysqli_fetch_assoc($result_rating);
        $average_rating = $average_rating_data['average_rating'];

        $updateSql = "UPDATE remedies SET rating = $average_rating WHERE id = $id";
        $updateResult = mysqli_query($conn, $updateSql);


        if ($response) {
            header("Location: ./disease_remedy_detail.php?id=$id");
            exit();
        } else {
            $errors['database'] = 'Error inserting record into the database';
        }
    }
}

$rating_data = "";
$reviews_data= [];

if($user_id){
    $rating_data = mysqli_fetch_assoc($result_rating);
    while ($row = mysqli_fetch_assoc($result_reviews)) {
        $reviews_data[] = $row;
    }
}

$data = mysqli_fetch_assoc($result_detail);

if (!$data) {
    die('Remedy not found');
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



$orderRelatedItems = array();

$orderItemQuery = " SELECT * FROM order_items WHERE remedy_id = $id";

$orderItemResult = mysqli_query($conn, $orderItemQuery);

while ($row = mysqli_fetch_assoc($orderItemResult)) {
    $orderId = $row['order_id'];

    $itemsQuery = " SELECT remedy_id FROM order_items WHERE order_id = $orderId";
    $itemsResult = mysqli_query($conn, $itemsQuery);

    while ($itemRow = mysqli_fetch_assoc($itemsResult)) {
        $remedyId = $itemRow['remedy_id'];

        if (!isset($orderRelatedItems[$orderId])) {
            $orderRelatedItems[$orderId] = array();
        }

        $orderRelatedItems[$orderId][] = $remedyId;
    }
}

$orderRelatedItems = array_values($orderRelatedItems);

$dataset_json = json_encode($orderRelatedItems);


$ratingQuery = "
SELECT 
    remedy_id,
    COUNT(*) AS total_reviews,
    SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) AS one_star,
    SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) AS two_star,
    SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) AS three_star,
    SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) AS four_star,
    SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) AS five_star
FROM 
    reviews
WHERE
    remedy_id = $id
GROUP BY 
    remedy_id;
";

$ratingResult = mysqli_query($conn, $ratingQuery);

$ratings = [
    'total_reviews' => 0,
    'one_star' => 0,
    'two_star' => 0,
    'three_star' => 0,
    'four_star' => 0,
    'five_star' => 0,
];

if ($row = mysqli_fetch_assoc($ratingResult)) {
    $totalReviews = $row['total_reviews'];
    $oneStar = $row['one_star'];
    $twoStar = $row['two_star'];
    $threeStar = $row['three_star'];
    $fourStar = $row['four_star'];
    $fiveStar = $row['five_star'];
    
    $ratings = array(
        'remedy_id' => $id,
        'total_reviews' => $totalReviews,
        'one_star' => $oneStar,
        'two_star' => $twoStar,
        'three_star' => $threeStar,
        'four_star' => $fourStar,
        'five_star' => $fiveStar
    );
}


include('./python/apriori.php');

