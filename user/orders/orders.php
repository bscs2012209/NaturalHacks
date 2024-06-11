<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['is_user'] !== 'user') {
    header("Location: ../login.php");
    exit; // Ensure script stops execution after redirect
}

require_once '../../connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Orders';
include('../layout/head.php');
?>

<body>
    <input type="checkbox" id="menu-toggle">
    <?php
    include('../layout/sidebar.php');
    ?>

    <div class="main-content">
        <?php include('../layout/header.php') ?>

        <main>
            <div class="page-header">
                <h3>Orders</h3>
            </div>
            <div class="page-content">
                <?php
                // Fetch orders with user names and remedy details
                $sql = "SELECT orders.*, 
                        GROUP_CONCAT(CASE WHEN CHAR_LENGTH(remedies.name) > 8 THEN CONCAT(SUBSTRING(remedies.name, 1, 8), '...') ELSE remedies.name END) AS remedy_names, 
                        GROUP_CONCAT(order_items.quantity) AS quantities
                        FROM orders 
                        LEFT JOIN order_items ON orders.id = order_items.order_id
                        LEFT JOIN remedies ON order_items.remedy_id = remedies.id
                        WHERE orders.user_id = '" . mysqli_real_escape_string($conn, $_SESSION['user_id']) . "'
                        GROUP BY orders.id";
                $orders_result = mysqli_query($conn, $sql);

                if ($orders_result) {
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
                                            <th>Remedy Names</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $order_count = 0;
                                        while ($order = mysqli_fetch_assoc($orders_result)) {
                                            $order_count++;
                                            ?>
                                            <tr>
                                                <td><?= $order_count ?></td>
                                                <td><?= htmlspecialchars($order['remedy_names']) ?></td>
                                                <td><?= isset($order['quantities']) ? htmlspecialchars($order['quantities']) : '' ?></td>
                                                <td><?= htmlspecialchars($order['total_price']) ?></td>
                                                <td><?= htmlspecialchars($order['status']) ?></td>
                                                <td><?= htmlspecialchars($order['created_at']) ?></td>
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
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
                ?>
            </div>
        </main>
        
    </div>
</body>

</html>
