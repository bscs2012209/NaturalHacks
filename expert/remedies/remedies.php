<?php
session_start();
if (!isset($_SESSION['expert_id']) || $_SESSION['is_expert'] !== 'expert') {
    header("Location: ../login.php");
    exit();
}

require_once '../../connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Remedies';
include('../layout/head.php');
?>

<body>
    <input type="checkbox" id="menu-toggle">
    <?php
    include('../layout/sidebar.php');
    ?>

    <div class="main-content">
        <?php
        include('../layout/header.php');
        ?>

        <?php
        $sql = "SELECT * FROM remedies WHERE featured = 0";
        $remedies = mysqli_query($conn, $sql);

        if (isset($_POST['delete'])) {
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $sql = "DELETE FROM remedies WHERE id=$id";
            mysqli_query($conn, $sql);
        }
        ?>

        <main>
            <div class="page-header">
                <h3>Remedies</h3>
            </div>
            <div class="page-content">
                <div class="card">
                    <div class="records table-responsive">
                        <div>
                            <?php if (mysqli_num_rows($remedies) > 0) { ?>
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Remedy</th>
                                            <th>Price</th>
                                            <th>Expert App</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $key = 0;
                                        $rows = mysqli_fetch_all($remedies, MYSQLI_ASSOC); // Fetch all rows into an associative array

                                        foreach ($rows as $row) {
                                            $key++;
                                            $name = htmlspecialchars($row['name']);
                                            $price = number_format($row['price'], 2);
                                            $expert_approval = htmlspecialchars($row['expert_approval']);
                                            $created_at = date('d F Y H:i', strtotime($row['created_at']));
                                            $images = json_decode($row['images'], true);
                                            $image = (!empty($images[0]) && $images[0] !== null) ? htmlspecialchars($images[0]) : '../assets/images/photo.png';
                                        ?>
                                            <tr>
                                                <td><?= $key ?></td>
                                                <td>
                                                    <a href="./remedy_edit.php?id=<?= $row['id'] ?>" class="client">
                                                        <div class="client-img bg-img" style="background-image: url(<?= $image ?>); background-size: cover;"></div>
                                                        <div class="client-info">
                                                            <h4><?= $name ?></h4>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td><?= $price ?></td>
                                                <td><small><?= ucfirst($expert_approval) ?></small></td>
                                                <td><?= $created_at ?></td>
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