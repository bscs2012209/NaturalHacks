<?php
session_start();
require_once '../../connection.php';

// Check admin authentication
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$page_title = 'Remedies';

// Include head and sidebar
include('../layout/head.php');
include('../layout/sidebar.php');

$errors = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // Sanitize input
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    // Delete the remedy
    $sql = "DELETE FROM remedies WHERE id=$id";
    if (!mysqli_query($conn, $sql)) {
        // Handle database error
        $errors['database'] = 'Failed to delete remedy';
    }
}

$sql = "SELECT * FROM remedies";
$remedies_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../layout/header.php'); ?>

<body>
    <div class="main-content">
        <main>
            <div class="page-header">
                <h3>Remedies</h3>
            </div>
            <div class="page-content">
                <div class="card">
                    <div class="records table-responsive">
                        <div class="record-header">
                            <h4>All Remedies</h4>
                            <div class="add">
                                <a href="./remedy_add.php"><button>Add Remedy</button></a>
                            </div>
                        </div>
                        <div>
                            <?php if (mysqli_num_rows($remedies_result) > 0) { ?>
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Remedy</th>
                                            <th>Price</th>
                                            <th>Expert App</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $key = 0;
                                        while ($row = mysqli_fetch_assoc($remedies_result)) {
                                            $key++;
                                            $images = json_decode($row['images'], true);
                                            $image = (!empty($images[0]) && $images[0] !== null) ? $images[0] : '../assets/images/photo.png';
                                        ?>
                                            <tr>
                                                <td><?= $key ?></td>
                                                <td>
                                                    <div class="client">
                                                        <div class="client-img bg-img" style="background-image: url(<?= $image ?>); background-size:cover;"></div>
                                                        <div class="client-info">
                                                            <h4><?= $row['name'] ?></h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= number_format($row['price'], 2) ?></td>
                                                <td><small><?= ucfirst($row['expert_approval']) ?></small></td>
                                                <td><?= date('d F Y H:i', strtotime($row['created_at'])) ?></td>
                                                <td>
                                                    <div class="actions">
                                                        <a href="./remedy_edit.php?id=<?= $row['id'] ?>">
                                                            <img src="../assets/images/edit.png" height="20px" alt="">
                                                        </a>
                                                        <form class="delete-form" id="deleteForm_<?= $row['id'] ?>" action="" method="post">
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
