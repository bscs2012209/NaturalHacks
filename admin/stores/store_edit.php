<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../../connection.php';

$errors = [];
$id = $_GET['id'] ?? null;

if (!$id) {
    die('Invalid ID');
}

$sql = "SELECT * FROM `stores` WHERE `id` = '$id'";
$result = mysqli_query($conn, $sql);
$store = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $latitude = mysqli_real_escape_string($conn, $_POST['latitude'] ?? '');
    $longitude = mysqli_real_escape_string($conn, $_POST['longitude'] ?? '');
    $commission_rate = mysqli_real_escape_string($conn, $_POST['commission_rate'] ?? '');

    $query = "UPDATE `stores` SET ";
    $updateFields = [];

    if (!empty($name)) {
        $updateFields[] = "`name` = '$name'";
    }

    if (!empty($address)) {
        $updateFields[] = "`address` = '$address'";
    }
    
    if (!empty($latitude)) {
        $updateFields[] = "`latitude` = '$latitude'";
    }
    
    if (!empty($longitude)) {
        $updateFields[] = "`longitude` = '$longitude'";
    }
    
    if (!empty($commission_rate)) {
        $updateFields[] = "`commission_rate` = '$commission_rate'";
    }

    if (!empty($updateFields)) {
        $query .= implode(', ', $updateFields);
        $query .= " WHERE `id` = '$id'";

        $response = mysqli_query($conn, $query);

        if($response){
            header("Location: ./stores.php");
            exit();
        } else {
            $errors['database'] = 'Failed to update data in the database';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Edit Store';
include('../layout/head.php');
?>

<body>
    <?php include('../layout/sidebar.php'); ?>

    <div class="main-content">
        <?php include('../layout/header.php'); ?>

        <main>
            <div class="page-content">
                <div class="card">
                    <h2 class="page-heading">Edit Store</h2>

                    <form class="page-form" action="store_edit.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($store['name'] ?? '') ?>">
                            <span class="error"><?php echo $errors['name'] ?? ''; ?></span>
                        </fieldset>
                        
                        <fieldset>
                            <label for="commission_rate">Commission Rate:</label>
                            <input type="text" name="commission_rate" value="<?= htmlspecialchars($store['commission_rate']) ?>">
                            <span class="error"><?php echo $errors['commission_rate'] ?? ''; ?></span>
                        </fieldset>

                        <fieldset>
                            <label for="address">Address:</label>
                            <input type="text" name="address" value="<?= htmlspecialchars($store['address']) ?>">
                            <span class="error"><?php echo $errors['address'] ?? ''; ?></span>
                        </fieldset>
                    
                        <fieldset>
                            <label for="latitude">Latitude:</label>
                            <input type="text" name="latitude" value="<?= htmlspecialchars($store['latitude']) ?>">
                            <span class="error"><?php echo $errors['latitude'] ?? ''; ?></span>
                        </fieldset>
                    
                        <fieldset>
                            <label for="longitude">Longitude:</label>
                            <input type="text" name="longitude" value="<?= htmlspecialchars($store['longitude']) ?>">
                            <span class="error"><?php echo $errors['longitude'] ?? ''; ?></span>
                        </fieldset>
                  
                        <span class="error"><?php echo $errors['database'] ?? ''; ?></span>
                        <input type="submit" class="form-submit" value="Update Store">
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
