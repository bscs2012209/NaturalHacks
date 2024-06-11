<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../../connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Users';
include('../layout/head.php');
?>

<body>
    <input type="checkbox" id="menu-toggle">
    <?php
    include('../layout/sidebar.php');
    ?>

    <div class="main-content">
        <?php include('../layout/header.php') ?>

        <?php
        $sql = "SELECT * FROM users";
        $users = mysqli_query($conn, $sql);

        if (isset($_POST['delete'])) {
            $id = mysqli_real_escape_string($conn, $_POST['id']);
        
            mysqli_begin_transaction($conn);
        
            try {
                $sql = "DELETE FROM forget_passwords WHERE user_id = $id";
                mysqli_query($conn, $sql);
        
                $sql = "DELETE FROM order_items WHERE order_id IN (SELECT id FROM orders WHERE user_id = $id)";
                mysqli_query($conn, $sql);
        
                $sql = "DELETE FROM orders WHERE user_id = $id";
                mysqli_query($conn, $sql);
        
                $sql = "DELETE FROM reviews WHERE user_id = $id";
                mysqli_query($conn, $sql);
        
                $sql = "DELETE FROM cart WHERE user_id = $id";
                mysqli_query($conn, $sql);
        
                $sql = "DELETE FROM users WHERE id = $id";
                mysqli_query($conn, $sql);
        
                mysqli_commit($conn);
            } catch (Exception $e) {
                mysqli_rollback($conn);
                echo "Failed to delete user and associated records: " . $e->getMessage();
            }

            header("Location: " . $_SERVER['PHP_SELF']);
        }
        
        ?>

        <main>
            <div class="page-header">
                <h3>Users</h3>
            </div>
            <div class="page-content">
                <div class="card">
                    <div class="record-header">
                        <h4>All Users</h4>
                    </div>
                    <div class="records table-responsive">

                        <div>
                            <?php
                            if (mysqli_num_rows($users) > 0) {
                                ?>
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($users as $key => $row) {
                                            $key++;
                                            if (!empty($row['image']) && $row['image'] !== null) {
                                                $image = $row['image'];
                                            } else {
                                                $image = '../assets/images/photo.png';
                                            }
                                        ?>

                                            <tr>
                                                <td><?= $key ?></td>
                                                <td>
                                                    <div class="client">
                                                        <div class="client-img bg-img" style="background-image: url(<?= $image ?>); background-size:cover; border: none;"></div>
                                                        <div class="client-info">
                                                            <h4><?= htmlspecialchars($row['name']) ?></h4>
                                                            <span><?= htmlspecialchars($row['phone']) ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($row['email']) ?></td>
                                                <td><?= date('d F Y H:i', strtotime($row['created_at'])) ?></td>
                                                <td>
                                                    <div class="actions">
                                                        <form class="delete-form" id="deleteForm_<?= $row['id'] ?>" action="./users.php" method="post">
                                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                            <button type="submit" style="border:none; background-color: none;" onclick="return confirm(' Are you sure you want to delete <?= htmlspecialchars($row['name']) ?>?')" name="delete">
                                                                <img src="../assets/images/delete.png" height="20px" alt="">
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <div class="no-data">
                                    <img src="../assets/images/no-data.jpg" />
                                    <h1>No records found</h1>
                                </div>';
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
