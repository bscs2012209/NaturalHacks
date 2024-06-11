<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
}

require_once '../../connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Stores';
include('../layout/head.php');
?>

<body>
    <input type="checkbox" id="menu-toggle">
    <?php
    include('../layout/sidebar.php');
    ?>


    <?php 
        $sql = "SELECT * FROM stores";
        $stores = mysqli_query($conn, $sql);

        
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $sql = "DELETE FROM stores WHERE id=$id";
            mysqli_query($conn, $sql);
        }
    ?>


    <div class="main-content">
        <?php include('../layout/header.php') ?>

        <main>
            <div class="page-header">
                <h3>Stores</h3>
            </div>
            <div class="page-content">
                <div class="card">
                    <div class="records table-responsive">
                        <div class="record-header">
                        <h4>All Stores</h4>
                            <div class="add">
                                <a href="./store_add.php"><button>Add Store</button></a>
                            </div>
                        </div>

                        <div>
                            <?php if (mysqli_num_rows($stores) > 0) { ?>
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Store</th>
                                            <th>Address</th>
                                            <th>Actions</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($stores as $key => $row) {
                                            $key++;
                                            
                                        ?>
                                            <tr>
                                                <td><?= $key ?></td>
                                                <td>
                                                    <a href="https://maps.google.com/?q=<?= $row['latitude'] ?>,<?= $row['longitude'] ?>" class="client">
                                                        <div class="client-info">
                                                            <h4><?= $row['name'] ?></h4>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <p>
                                                        <?= $row['address'] ?>
                                                    </p>
                                                </td>
                                                <td>
                                                    <div class="actions">
                                                        <a href="./store_edit.php?id=<?= $row['id'] ?>">
                                                            <img src="../assets/images/edit.png" height="20px" alt="">
                                                        </a>
                                                        <form class="delete-form" id="deleteForm_<?= $row['id'] ?>" action="./stores.php" method="post">
                                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                            <button type="submit" style="border:none; background-color: none;" onclick="return confirm(' Are you sure you want to delete <?= $row['name'] ?> ?')" name="delete">
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