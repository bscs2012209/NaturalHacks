<?php
// require_once '../connection.php';

// $orderItemsGrouped = array();

// $orderItemQuery = "SELECT `order_id`, `remedy_id` FROM `order_items`";
// $orderItemResult = mysqli_query($conn, $orderItemQuery);

// while ($row = mysqli_fetch_assoc($orderItemResult)) {
//     $orderId = $row['order_id'];
//     $remedyId = $row['remedy_id'];
    
//     if (!isset($orderItemsGrouped[$orderId])) {
//         $orderItemsGrouped[$orderId] = array();
//     }
    
//     $orderItemsGrouped[$orderId][] = $remedyId;
// }

// $orderItemsGrouped = array_values($orderItemsGrouped);

// $dataset_json = json_encode($orderItemsGrouped);




// // API URL
// $url = 'http://localhost:8000';

// // Set up the POST request
// $options = array(
//     'http' => array(
//         'method'  => 'POST',
//         'header'  => 'Content-Type: application/json',
//         'content' => $dataset_json
//     )
// );

// // Create a stream context
// $context  = stream_context_create($options);

// // Make the POST request and retrieve the response
// $response = file_get_contents($url, false, $context);

// // Check for errors
// if ($response === false) {
//     echo 'Error while fetching response from the API.';
// } else {
//     // Output JSON response
//     $suggested = json_decode($response);
    
// }




$url = 'https://kashafkhalid.pythonanywhere.com/run-apriori';
// $url = 'http://localhost:8000';

// Set up the POST request
$options = array(
    'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-Type: application/json',
        'content' => $dataset_json
    )
);

// Create a stream context
$context  = stream_context_create($options);

// Make the POST request and retrieve the response
$response = file_get_contents($url, false, $context);

// Check for errors
if ($response === false) {
    echo 'Error while fetching response from the API.';
} else {
    // Output JSON response
    $suggested = json_decode($response, true);
}
?>
