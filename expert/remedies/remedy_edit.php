<?php
session_start();
if (!isset($_SESSION['expert_id']) || $_SESSION['is_expert'] !== 'expert') {
    header("Location: ../login.php");
    exit();
}

require_once '../../connection.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<?php
$page_title = 'Remedies';
include('../layout/head.php');
?>

<body>
    <input type="checkbox" id="menu-toggle">
    <?php include('../layout/sidebar.php'); ?>

    <div class="main-content">
        <?php include('../layout/header.php'); ?>

        <?php
        $sql = "SELECT * FROM `remedies` WHERE `id` = '$id'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $expert_feedback = mysqli_real_escape_string($conn, $_POST['expert_feedback'] ?? '');
            $expert_approval = mysqli_real_escape_string($conn, $_POST['expert_approval'] ?? 'waiting');

            $query = "UPDATE `remedies` SET ";
            $updateFields = [];

            if (!empty($expert_feedback)) {
                $updateFields[] = "`expert_feedback` = '$expert_feedback'";
            }

            if (!empty($expert_approval)) {
                $updateFields[] = "`expert_approval` = '$expert_approval'";
            }

            if (!empty($updateFields)) {
                $query .= implode(', ', $updateFields);
                $query .= " WHERE `id` = '$id'";
            }

            $response = mysqli_query($conn, $query);

            if ($response) {
                header("Location: ./remedies.php");
                exit();
            } else {
                $errors['database'] = 'Failed to update data into the database';
            }
        }
        ?>

        <main>
            <div class="page-header">
                <h3>Remedies</h3>
            </div>
            <div class="page-content">
                <div class="card">
                    <div class="details">
                        <div class="details-img">
                            <?php $image = json_decode($data['images'])[0] ?>
                            <img src="<?= $image ?>" alt="">
                        </div>
                        <div class="details-content">
                            <h1><?= $data['name'] ?></h1>
                            <?php if (!empty($data['ingredients'])) { ?>
                                <h2>Ingredients:</h2>
                                <p><?= $data['ingredients'] ?></p>
                            <?php } ?>
                            <?php if (!empty($data['how_to_make'])) { ?>
                                <h2>How To Make:</h2>
                                <p><?= $data['how_to_make'] ?></p>
                            <?php } ?>
                            <?php if (!empty($data['advantages'])) { ?>
                                <h2>Advantages:</h2>
                                <p><?= $data['advantages'] ?></p>
                            <?php } ?>
                            <?php if (!empty($data['dis_advantages'])) { ?>
                                <h2>Dis Advantages:</h2>
                                <p><?= $data['dis_advantages'] ?></p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="edit-form">
                        <h2>Change Approval</h2>
                        <form action="./remedy_edit.php?id=<?= $id ?>" method="post">
                            <fieldset>
                                <label for="expert_approval">Approval Status</label>
                                <select name="expert_approval">
                                    <option value="waiting" <?= $data['expert_approval'] == 'waiting' ? 'selected' : '' ?>>Waiting</option>
                                    <option value="approved" <?= $data['expert_approval'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                    <option value="declined" <?= $data['expert_approval'] == 'declined' ? 'selected' : '' ?>>Declined</option>
                                </select>
                            </fieldset>
                            <fieldset>
                                <label for="expert_feedback">Feedback</label>
                                <textarea name="expert_feedback" cols="30" rows="10" placeholder="Your Feedback"><?= $data['expert_feedback'] ?></textarea>
                            </fieldset>
                            <input type="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
