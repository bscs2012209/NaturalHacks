<?php
session_start();
require_once '../../connection.php';

$errors = [];
$name = $latitude = $longitude = $address = $commission_rate = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $latitude = mysqli_real_escape_string($conn, $_POST['latitude'] ?? '');
    $longitude = mysqli_real_escape_string($conn, $_POST['longitude'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $commission_rate = mysqli_real_escape_string($conn, $_POST['commission_rate'] ?? '');

    // Validate Name
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }

    // Validate Latitude
    if (empty($latitude)) {
        $errors['latitude'] = 'Latitude is required';
    }

    // Validate Longitude
    if (empty($longitude)) {
        $errors['longitude'] = 'Longitude is required';
    }

    // Validate Address
    if (empty($address)) {
        $errors['address'] = 'Address is required';
    }

    // Validate Commission Rate
    if (empty($commission_rate)) {
        $errors['commission_rate'] = 'Commission Rate is required';
    }

    // If there are no validation errors, proceed with database insertion
    if (empty($errors)) {
        $insertSql = "INSERT INTO `stores` (
            `name`,
            `latitude`,
            `longitude`,
            `address`,
            `commission_rate`
        ) VALUES (
            '$name',
            '$latitude',
            '$longitude',
            '$address',
            '$commission_rate'
        )";

        $response = mysqli_query($conn, $insertSql);

        if ($response) {
            header("Location: ./stores.php");
            exit();
        } else {
            // Handle the error
            $errors['database'] = 'Error inserting record into the database';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Add Store';
include('../layout/head.php');
?>

<body>
    <input type="checkbox" id="menu-toggle">
    <?php include('../layout/sidebar.php'); ?>

    <div class="main-content">
        <?php include('../layout/header.php'); ?>

        <main>
            <div class="page-content">
                <div class="card">
                    <h2 class="page-heading">Add Store</h2>

                    <form class="page-form" action="store_add.php" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
                            <span class="error"><?= $errors['name'] ?? '' ?></span>
                        </fieldset>
                        
                        <fieldset>
                            <label for="commission_rate">Commission Rate:</label>
                            <input type="text" name="commission_rate" value="<?= htmlspecialchars($commission_rate) ?>">
                            <span class="error"><?= $errors['commission_rate'] ?? '' ?></span>
                        </fieldset>

                        <fieldset>
                            <label for="address">Address:</label>
                            <input type="text" name="address" value="<?= htmlspecialchars($address) ?>">
                            <span class="error"><?= $errors['address'] ?? '' ?></span>
                        </fieldset>
                    
                        <fieldset>
                            <label for="latitude">Latitude:</label>
                            <input type="text" name="latitude" value="<?= htmlspecialchars($latitude) ?>">
                            <span class="error"><?= $errors['latitude'] ?? '' ?></span>
                        </fieldset>
                    
                        <fieldset>
                            <label for="longitude">Longitude:</label>
                            <input type="text" name="longitude" value="<?= htmlspecialchars($longitude) ?>">
                            <span class="error"><?= $errors['longitude'] ?? '' ?></span>
                        </fieldset>
                                           
                        <input type="submit" class="form-submit" value="Add Store">
                    </form>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
