<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../../connection.php';

$name = '';
$discount = '';
$type = '';
$start_date = '';
$end_date = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $discount = trim($_POST['discount'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $start_date = trim($_POST['start_date'] ?? '');
    $end_date = trim($_POST['end_date'] ?? '');

    // Escape user inputs to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $name);
    $discount = mysqli_real_escape_string($conn, $discount);
    $type = mysqli_real_escape_string($conn, $type);
    $start_date = mysqli_real_escape_string($conn, $start_date);
    $end_date = mysqli_real_escape_string($conn, $end_date);

    // Validate Name
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }

    // Validate Discount
    if (empty($discount)) {
        $errors['discount'] = 'Discount is required';
    } elseif (!is_numeric($discount) || $discount <= 0) {
        $errors['discount'] = 'Discount must be a positive number';
    }

    // Validate Type
    if (empty($type)) {
        $errors['type'] = 'Type is required';
    } elseif (!in_array($type, ['flat', 'percent'])) {
        $errors['type'] = 'Invalid type selected';
    }

    // Validate Start Date
    if (empty($start_date)) {
        $errors['start_date'] = 'Start Date is required';
    }

    // Validate End Date
    if (empty($end_date)) {
        $errors['end_date'] = 'End Date is required';
    } elseif ($end_date < $start_date) {
        $errors['end_date'] = 'End Date cannot be earlier than Start Date';
    }

    // Check for overlapping date ranges
    if (empty($errors)) {
        $checkSql = "SELECT COUNT(*) as count FROM `discounts` 
                     WHERE 
                     (`start_date` <= '$end_date' AND `end_date` >= '$start_date')";

        $checkResult = mysqli_query($conn, $checkSql);
        $row = mysqli_fetch_assoc($checkResult);

        if ($row['count'] > 0) {
            $errors['overlap'] = 'A discount already exists within the selected date range';
        }
    }

    // If there are no validation errors, proceed with database insertion
    if (empty($errors)) {
        $insertSql = "INSERT INTO `discounts` (
            `name`,
            `discount`,
            `type`,
            `start_date`,
            `end_date`
        ) VALUES (
            '$name',
            '$discount',
            '$type',
            '$start_date',
            '$end_date'
        )";

        $response = mysqli_query($conn, $insertSql);

        if ($response) {
            header("Location: ./discounts.php");
            exit();
        } else {
            $errors['database'] = 'Error inserting record into the database';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Add Discount';
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
            <div class="page-content">
                <div class="card">
                    <h2 class="page-heading">Add Discount</h2>

                    <form class="page-form" action="discount_add.php" method="POST">
                        <fieldset>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
                            <span class="error"><?php echo $errors['name'] ?? ''; ?></span>
                        </fieldset>

                        <fieldset>
                            <label for="discount">Discount:</label>
                            <input type="text" name="discount" value="<?= htmlspecialchars($discount) ?>">
                            <span class="error"><?php echo $errors['discount'] ?? ''; ?></span>
                        </fieldset>
                        
                        <fieldset>
                            <label for="type">Type:</label>
                            <select name="type">
                                <option value="flat" <?= $type == 'flat' ? 'selected' : '' ?>>Flat</option>
                                <option value="percent" <?= $type == 'percent' ? 'selected' : '' ?>>Percent</option>
                            </select>
                            <span class="error"><?php echo $errors['type'] ?? ''; ?></span>
                        </fieldset>

                        <fieldset>
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
                            <span class="error"><?php echo $errors['start_date'] ?? ''; ?></span>
                        </fieldset>
                    
                        <fieldset>
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
                            <span class="error"><?php echo $errors['end_date'] ?? ''; ?></span>
                        </fieldset>

                        <span class="error"><?php echo $errors['overlap'] ?? ''; ?></span>
                        <span class="error"><?php echo $errors['database'] ?? ''; ?></span>

                        <input type="submit" class="form-submit" value="Add Discount">
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
