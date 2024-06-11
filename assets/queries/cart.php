<?php

include('../../connection.php');
include('./helpers/get_remedy_detail.php');
session_start();

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

function retrieveCartData($conn)
{
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    $cart_sql = "SELECT c.*, r.name AS remedy_name, r.price AS remedy_price 
                 FROM cart c 
                 JOIN remedies r ON c.remedy_id = r.id 
                 WHERE c.user_id = '$userId'";
    
    $cart_detail = mysqli_query($conn, $cart_sql);
    
    return mysqli_fetch_all($cart_detail, MYSQLI_ASSOC);
}

function addToCart($conn, $remedyId)
{
    // Fetch remedy price only once
    $data = getRemedyDetail($remedyId, $conn);
    $remedyPrice = $data['price'];

    // Check if the item is already in the cart
    $checkSql = "SELECT * FROM cart WHERE user_id='{$_SESSION['user_id']}' AND remedy_id='$remedyId'";
    $checkResult = mysqli_query($conn, $checkSql);
    if (!$checkResult) {
        die ('Error checking cart: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($checkResult) > 0) {
        // If item is already in the cart, update quantity and price
        $updateSql = "UPDATE cart SET quantity = quantity + 1, price = price + $remedyPrice WHERE user_id='{$_SESSION['user_id']}' AND remedy_id='$remedyId'";
        if (mysqli_query($conn, $updateSql)) {
            $response['success'] = true;
            $response['message'] = 'Quantity updated in cart successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Error updating quantity in cart: ' . mysqli_error($conn);
        }
    } else {
        // If item is not in the cart, insert new entry
        $insertSql = "INSERT INTO cart (user_id, remedy_id, quantity, price) 
                      VALUES ('{$_SESSION['user_id']}', '$remedyId', 1, '$remedyPrice')";
        if (mysqli_query($conn, $insertSql)) {
            $response['success'] = true;
            $response['message'] = 'Remedy added to cart successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Error adding remedy to cart: ' . mysqli_error($conn);
        }
    }

    // Get updated cart data
    $response['cartData'] = retrieveCartData($conn);
    
    echo json_encode($response);
}

function increaseQuantity($conn, $remedyId)
{
    $response['success'] = false;
    $response['message'] = "";

    $remedyDetail = getRemedyDetail($remedyId, $conn);
    $remedyPrice = $remedyDetail['price'];

    $updateSql = "UPDATE cart SET quantity = quantity + 1, price = price + $remedyPrice WHERE user_id='{$_SESSION['user_id']}' AND remedy_id='$remedyId'";
    
    if (mysqli_query($conn, $updateSql)) {
        $response['success'] = true;
        $response['message'] = 'Quantity updated in cart successfully';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error updating quantity in cart: ' . mysqli_error($conn);
    }

    // Get updated cart data
    $response['cartData'] = retrieveCartData($conn);
    
    echo json_encode($response);
}

function decreaseQuantity($conn, $remedyId)
{
    $remedyDetail = getRemedyDetail($remedyId, $conn);
    $remedyPrice = $remedyDetail['price'];

    $updateSql = "UPDATE cart SET quantity = quantity - 1, price = price - $remedyPrice WHERE user_id='{$_SESSION['user_id']}' AND remedy_id='$remedyId' AND quantity > 0";
    
    if (mysqli_query($conn, $updateSql)) {
        $checkZeroQuantitySql = "SELECT * FROM cart WHERE user_id='{$_SESSION['user_id']}' AND remedy_id='$remedyId' AND quantity = 0";
        $checkZeroQuantityResult = mysqli_query($conn, $checkZeroQuantitySql);
        if (mysqli_num_rows($checkZeroQuantityResult) > 0) {
            $removeZeroQuantitySql = "DELETE FROM cart WHERE user_id='{$_SESSION['user_id']}' AND remedy_id='$remedyId'";
            mysqli_query($conn, $removeZeroQuantitySql);
        }

        $response['success'] = true;
        $response['message'] = 'Quantity updated in cart successfully';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error updating quantity in cart: ' . mysqli_error($conn);
    }

    // Get updated cart data
    $response['cartData'] = retrieveCartData($conn);

    echo json_encode($response);
}

function removeItemsFromCart($conn) {
    $removeSql = "DELETE FROM cart WHERE user_id='{$_SESSION['user_id']}'";
    if (!mysqli_query($conn, $removeSql)) {
        $response['success'] = false;
        $response['message'] = 'Error removing items from cart: ' . mysqli_error($conn);
    } else {
        $response['success'] = true;
        $response['message'] = 'Items removed from cart successfully';
    }

    // Get updated cart data
    $response['cartData'] = retrieveCartData($conn);
    
    return $response;

}


function checkDiscount($amount, $discount) {
    if ($discount === null) {
        return $amount;
    }   

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


function insertOrderDetails($conn, $totalPrice, $orderItems, $discount) {

    $discountedPrice = checkDiscount($totalPrice, $discount);

    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $orderDate = date('Y-m-d H:i:s');
    $insertOrderSql = "INSERT INTO orders (user_id, total_price, created_at) VALUES ('$userId', $discountedPrice, '$orderDate')";
    if (mysqli_query($conn, $insertOrderSql)) {
        $orderId = mysqli_insert_id($conn);

        foreach ($orderItems as $item) {
            $insertOrderItemSql = "INSERT INTO order_items (order_id, remedy_id, quantity, price) VALUES ($orderId, {$item['remedy_id']}, {$item['quantity']}, {$item['price']})";
            mysqli_query($conn, $insertOrderItemSql);
        }

        return $orderId;
    } else {
        $response = array('error' => 'Error inserting order details: ' . mysqli_error($conn));
        
        return false;
    }
}

function checkoutProcess($conn) {
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $cartSql = "SELECT * FROM cart WHERE user_id='$userId'";
    $cartResult = mysqli_query($conn, $cartSql);

    if (!$cartResult) {
        $response = array('error' => 'Error fetching cart items: ' . mysqli_error($conn));
        echo json_encode($response);
        exit;
    }

    $totalPrice = 0;
    $orderItems = [];
    while ($cartItem = mysqli_fetch_assoc($cartResult)) {
        $subtotal = $cartItem['price'];
        $totalPrice += $subtotal;

        $orderItems[] = [
            'remedy_id' => $cartItem['remedy_id'],
            'quantity' => $cartItem['quantity'],
            'price' => $cartItem['price'],
            'subtotal' => $subtotal, 
        ];
    }


    $discount = null;
    $currentDate = date('Y-m-d');
    
    $query = "SELECT * FROM `discounts` WHERE `start_date` <= '$currentDate' AND `end_date` >= '$currentDate' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $discount = mysqli_fetch_assoc($result);
    }
    
    
    removeItemsFromCart($conn);

    $orderId = insertOrderDetails($conn, $totalPrice, $orderItems, $discount);

    if ($orderId) {
        // If order ID is retrieved successfully
        $response['success'] = true;
        $response['message'] = 'Checkout successful! Total amount: ' . $totalPrice;
        $response['cartData'] = retrieveCartData($conn);
        $response['orderId'] = $orderId; // Include order ID in the response
    } else {
        $response['success'] = false;
        $response['message'] = 'Error processing checkout';
    }

    echo json_encode($response);
}

function initialize($conn){
    $response['success'] = false;
    $response['message'] = "";

    $response['cartData'] = retrieveCartData($conn);

    $response['success'] = true;
    $response['message'] = "Done initialization successfully";


    echo json_encode($response);
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remedy_id']) && isset($_POST['operation']) && $_POST['operation'] == 'add') {
        $remedyId = $_POST['remedy_id'];
        addToCart($conn, $remedyId);
    } elseif (isset($_POST['remedy_id']) && isset($_POST['operation']) && $_POST['operation'] == 'increase') {
        $remedyId = $_POST['remedy_id'];
        increaseQuantity($conn, $remedyId);
    } elseif (isset($_POST['remedy_id']) && isset($_POST['operation']) && $_POST['operation'] == 'decrease') {
        $remedyId = $_POST['remedy_id'];
        decreaseQuantity($conn, $remedyId);
    } elseif (isset($_POST['operation']) && $_POST['operation'] == "checkout") {
        checkoutProcess($conn);
    } elseif (isset($_POST['operation']) && $_POST['operation'] == "initialize") {
        initialize($conn);
    }
}
