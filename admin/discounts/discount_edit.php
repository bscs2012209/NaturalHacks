<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../../connection.php';

$errors = [];

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die('Invalid ID');
}

$id = mysqli_real_escape_string($conn, $id);

$sql = "SELECT * FROM `discounts` WHERE `id` = '$id'";
$result = mysqli_query($conn, $sql);
$discountArray = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $discount = mysqli_real_escape_string($conn, $_POST['discount'] ?? '');
    $type = mysqli_real_escape_string($conn, $_POST['type'] ?? '');
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date'] ?? '');
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date'] ?? '');

    $query = "UPDATE `discounts` SET ";
    $updateFields = [];

    if (!empty($name)) {
        $updateFields[] = "`name` = '$name'";
    }

    if (!empty($discount)) {
        $updateFields[] = "`discount` = '$discount'";
    }
    
    if (!empty($type)) {
        $updateFields[] = "`type` = '$type'";
    }
    
    if (!empty($start_date)) {
        $updateFields[] = "`start_date` = '$start_date'";
    }
    
    if (!empty($end_date)) {
        $updateFields[] = "`end_date` = '$end_date'";
    }

    if (!empty($updateFields)) {
        $query .= implode(', ', $updateFields);
        $query .= " WHERE `id` = '$id'";
    }

    $response = mysqli_query($conn, $query);

    if ($response) {
        header("Location: ./discounts.php");
        exit();
    } else {
        $errors['database'] = 'Failed to update data in the database';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Edit Discounts';
include('../layout/head.php');
?>

<body>
    <?php
    include('../layout/sidebar.php');
    ?>

    <div class="main-content">
        <?php include('../layout/header.php') ?>

        <main>
            <div class="page-content">
                <div class="card">
                    <h2 class="page-heading">Edit Discount</h2>

                    <form class="page-form" action="discount_edit.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($discountArray['name'] ?? '') ?>">
                            <span class="error"><?= $errors['name'] ?? ''; ?></span>
                        </fieldset>
                        
                        <fieldset>
                            <label for="discount">Discount:</label>
                            <input type="text" name="discount" value="<?= htmlspecialchars($discountArray['discount']) ?>">
                            <span class="error"><?= $errors['discount'] ?? ''; ?></span>
                        </fieldset>

                        <fieldset>
                            <label for="type">Type:</label>
                            <select name="type">
                                <option value="flat" <?= $discountArray['type'] == 'flat' ? 'selected' : '' ?>>Flat</option>
                                <option value="percent" <?= $discountArray['type'] == 'percent' ? 'selected' : '' ?>>Percent</option>
                            </select>
                            <span class="error"><?= $errors['type'] ?? ''; ?></span>
                        </fieldset>

                        <fieldset>
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" value="<?= htmlspecialchars($discountArray['start_date']) ?>">
                            <span class="error"><?= $errors['start_date'] ?? ''; ?></span>
                        </fieldset>
                    
                        <fieldset>
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" value="<?= htmlspecialchars($discountArray['end_date']) ?>">
                            <span class="error"><?= $errors['end_date'] ?? ''; ?></span>
                        </fieldset>
                    
                        <span class="error"><?= $errors['database'] ?? ''; ?></span>
                        <input type="submit" class="form-submit" value="Update Discount">
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor.create(document.querySelector('.description-editor'))
            .catch(error => console.error(error));
    </script>
</body>

</html>
