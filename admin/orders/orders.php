<?php
session_start();
require_once '../../connection.php';

// Check admin authentication
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$page_title = 'Orders';

// Include head and sidebar
include_once '../layout/head.php';
include_once '../layout/sidebar.php';

$errors = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    // Sanitize input
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the order status in the database
    $update_query = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    if (!mysqli_query($conn, $update_query)) {
        // Handle database error
        $errors['database'] = 'Failed to update order status';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; ?>

<body>
    <div class="main-content">
        <main>
            <div class="page-header">
                <h3>Orders</h3>
            </div>
            <div class="page-content">
                <?php
                // Fetch orders with user names and remedy details
                $sql = "SELECT orders.*, users.name AS user_name, GROUP_CONCAT(order_items.remedy_id) AS remedy_ids, GROUP_CONCAT(order_items.quantity) AS quantities
                        FROM orders 
                        INNER JOIN users ON orders.user_id = users.id
                        LEFT JOIN order_items ON orders.id = order_items.order_id
                        GROUP BY orders.id";
                $orders_result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($orders_result) > 0) {
                    ?>
                    <div class="card">
                        <div class="record-header">
                            <h4>All Orders</h4>
                        </div>
                        <div class="records table-responsive">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Remedy IDs</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Loop through orders
                                    $order_count = 0;
                                    while ($order = mysqli_fetch_assoc($orders_result)) {
                                        $order_count++;
                                        ?>
                                        <tr>
                                            <td><?= $order_count ?></td>
                                            <td><?= htmlspecialchars($order['user_name']) ?></td>
                                            <td><?= htmlspecialchars($order['remedy_ids']) ?></td>
                                            <td><?= isset($order['quantities']) ? htmlspecialchars($order['quantities']) : '' ?></td>
                                            <td><?= htmlspecialchars($order['total_price']) ?></td>
                                            <td><?= htmlspecialchars($order['status']) ?></td>
                                            <td><?= htmlspecialchars($order['created_at']) ?></td>
                                            <td>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                    <select name="status" onchange="this.form.submit()">
                                                        <option value="pending" <?= ($order['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                                                        <option value="processing" <?= ($order['status'] == 'processing') ? 'selected' : '' ?>>Processing</option>
                                                        <option value="shipped" <?= ($order['status'] == 'shipped') ? 'selected' : '' ?>>Shipped</option>
                                                        <option value="delivered" <?= ($order['status'] == 'delivered') ? 'selected' : '' ?>>Delivered</option>
                                                        <option value="cancelled" <?= ($order['status'] == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php
                } else {
                    echo "<div class='no-data'>
                            <img src='../assets/images/no-data.jpg' />
                            <h1>No records found</h1>
                        </div>";
                }
                ?>
            </div>
        </main>
    </div>
</body>

</html>
