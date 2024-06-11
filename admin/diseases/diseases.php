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
$page_title = 'Diseases';
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
        $sql = "SELECT * FROM diseases";
        $disease = mysqli_query($conn, $sql);

        if (isset($_POST['delete'])) {
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $deleteSql = "DELETE FROM diseases WHERE id = '$id'";
            mysqli_query($conn, $deleteSql);
        }
        ?>

        <main>
            <div class="page-header">
                <h3>Disease Categories</h3>
            </div>

            <div class="page-content">
                <div class="card">
                    <div class="records table-responsive">
                        <div class="record-header">
                            <h4>All Diseases</h4>
                            <div class="add">
                                <a href="./disease_add.php"><button>Add Disease</button></a>
                            </div>
                    </div>
                    
                    <div>
                        <?php
                        if (mysqli_num_rows($disease) > 0) {
                        ?>
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Disease</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rows = mysqli_fetch_all($disease, MYSQLI_ASSOC); // Fetch all rows into an associative array
                                    $key = 0; // Initialize the key variable

                                    foreach ($rows as $row) {
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
                                                    <div class="client-img bg-img" style="background-image: url(<?= $image ?>); background-size: cover;"></div>
                                                    <div class="client-info">
                                                        <h4><?= $row['name'] ?></h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= date('d F Y H:i', strtotime($row['created_at'])) ?></td>
                                            <td>
                                                <div class="actions">
                                                    <a href="./disease_edit.php?id=<?= $row['id'] ?>">
                                                        <img src="../assets/images/edit.png" height="20px" alt="Edit">
                                                    </a>
                                                    <form class="delete-form" id="deleteForm_<?= $row['id'] ?>" action="./diseases.php" method="post">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <button type="submit" style="border:none; background-color: none;" onclick="return confirm('Are you sure you want to delete <?= $row['name'] ?> ?')" name="delete">
                                                            <img src="../assets/images/delete.png" height="20px" alt="Delete">
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
                                <img src="../assets/images/no-data.jpg" alt="No Data">
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
