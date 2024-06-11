<?php 
include './assets/queries/invoice.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Invoice';
$css_path = "./assets/css/invoice.css";
include './layout/head.php';
?>

<body>
    <?php include './layout/header.php'; ?>
    <div class="invoice">
        <div class="invoice-header">
            <div class="invoice-header-left">
                <h3>Customer Invoice</h3>
                <h5>Order ID: #00<?= htmlspecialchars($order['id']) ?></h5>
            </div>
            <div>
                <h2 class="logo">Natural <span>Hacks</span></h2>
            </div>
        </div>
        <div class="invoice-info">
            <div>
                <h3>Customer's Details</h3>
                <br>
                <p>Customer Name: &nbsp; <?= htmlspecialchars($user['name'] ?? 'Not Available') ?></p>
                <p>Customer Address: &nbsp; <?= htmlspecialchars($user['address'] ?? 'Not Available') ?></p>
                <p>Customer Phone No: &nbsp; <?= htmlspecialchars($user['phone'] ?? 'Not Available') ?></p>
                <p>Email: &nbsp; <?= htmlspecialchars($user['email'] ?? '') ?></p>
            </div>
        </div>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Sub Total</th>
                    <th>Discounted Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $order_item) : ?>
                    <tr>
                        <?php 
                            $remedyName = mysqli_real_escape_string($conn, getRemedyDetail($order_item['remedy_id'], $conn)['name']);
                            $quantity = htmlspecialchars($order_item['quantity']);
                            $price = htmlspecialchars($order_item['price']);
                            $subtotal = 'Rs.' . $price . ' x ' . $quantity;
                            $discountedPrice = "-";
                            if($discount){ 
                                $discountedPrice = 'Rs.' . checkDiscount($price, $discount);
                            }
                        ?>
                        <td><?= $remedyName ?></td>
                        <td><?= $quantity ?></td>
                        <td>Rs.<?= $price ?></td>
                        <td><?= $subtotal ?></td>
                        <td><?= $discountedPrice ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="invoice-total">
            <p><strong>Payment Method: COD</strong></p>
            <p><strong>Delivery Charges:</strong>Rs 200</p>
            <?php if($discount){ ?>
                <p><strong>Discount:</strong> <?= $discount['type'] == 'flat' ? 'Rs.' . htmlspecialchars($discount['discount']) : htmlspecialchars($discount['discount']) . '%' ?></p>
                <br>
            <?php } ?> 
                <p><strong>Total: </strong>Rs <?= $order['total_price'] + 200 ?></p>
            </div>
    </div>

    <?php include './layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./assets/js/remedy_detail.js"></script>
    <script src="./assets/js/header.js"></script>
</body>

</html>
