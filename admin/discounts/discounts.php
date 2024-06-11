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
$page_title = 'Discounts';
include('../layout/head.php');
?>

<body>
    <input type="checkbox" id="menu-toggle">
    <?php
    include('../layout/sidebar.php');
    ?>

    <?php 
        $sql = "SELECT * FROM discounts";
        $discounts = mysqli_query($conn, $sql);

        if (isset($_POST['delete'])) {
            $id = mysqli_real_escape_string($conn, $_POST['id']); // Escape input
            $sql = "DELETE FROM discounts WHERE id='$id'"; // Use escaped variable
            mysqli_query($conn, $sql);
        }
    ?>

    <div class="main-content">
        <?php include('../layout/header.php') ?>

        <main>
            <div class="page-header">
                <h3>Discounts</h3>
            </div>
            <div class="page-content">
                <div class="card">
                    <div class="records table-responsive">
                        <div class="record-header">
                            <h4>All Discounts</h4>
                            <div class="add">
                                <a href="./discount_add.php"><button>Add Discount</button></a>
                            </div>
                        </div>

                        <div>
                            <?php if (mysqli_num_rows($discounts) > 0) { ?>
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Discount</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Actions</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($discounts as $key => $row) {
                                            $key++;
                                        ?>
                                            <tr>
                                                <td><?= $key ?></td>
                                                <td>
                                                    <div class="client-info">
                                                        <h4><?= htmlspecialchars($row['name']) ?></h4>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="client-info">
                                                        <h4><?= $row['type'] == 'flat' ? 'Rs.'.$row['discount'] : $row['discount'].'%' ?></h4>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p>
                                                        <?= date('F, d Y', strtotime($row['start_date'])) ?>
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        <?= date('F, d Y', strtotime($row['end_date'])) ?>
                                                    </p>
                                                </td>
                                                <td>
                                                    <div class="actions">
                                                        <a href="./discount_edit.php?id=<?= $row['id'] ?>">
                                                            <img src="../assets/images/edit.png" height="20px" alt="">
                                                        </a>
                                                        <form class="delete-form" id="deleteForm_<?= $row['id'] ?>" action="./discounts.php" method="post">
                                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                            <button type="submit" style="border:none; background-color: none;" onclick="return confirm(' Are you sure you want to delete <?= htmlspecialchars($row['name']) ?> ?')" name="delete">
                                                                <img src="../assets/images/delete.png" height="20px" alt="">
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php  } else { ?>
                                <div class="no-data">
                                    <img src="../assets/images/no-data.jpg" />
                                    <h1>No records found</h1>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
