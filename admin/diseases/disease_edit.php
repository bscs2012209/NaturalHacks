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

$id = mysqli_real_escape_string($conn, $id);

$sql = "SELECT * FROM `diseases` WHERE `id` = '$id'";
$result = mysqli_query($conn, $sql);
$disease = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');

    $imagePath = '';
    if (!empty($_FILES['image']['name'])) {
        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/FypProject/assets/uploaded_images/diseases/';
        $imageName = str_replace([' ', ':'], '-', time() . '_' . basename($_FILES['image']['name']));
        $imageMove =  $uploadDirectory . $imageName;
        $imagePath = $_SERVER['HTTP_ORIGIN'] . '/FypProject/assets/uploaded_images/diseases/' . $imageName;

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imageMove)) {
            $errors['image'] = 'Failed to upload image';
        }

    } else {
        $imagePath = $disease['image'];
    }

    $query = "UPDATE `diseases` SET ";
    $updateFields = [];

    if (!empty($name)) {
        $updateFields[] = "`name` = '$name'";
    }

    if (!empty($description)) {
        $updateFields[] = "`description` = '$description'";
    }

    if (!empty($updateFields)) {
        $query .= implode(', ', $updateFields);
        $query .= " WHERE `id` = '$id'";
    }

    $response = mysqli_query($conn, $query);

    if ($response) {
        header("Location: ./diseases.php");
        exit();
    } else {
        $errors['database'] = 'Failed to update data in the database';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Edit Disease';
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
                    <h2 class="page-heading">Edit Disease</h2>

                    <form class="page-form" action="disease_edit.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($disease['name'] ?? '') ?>">
                            <span class="error"><?php echo $errors['name'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset>
                            <label for="image">Image:</label>
                            <input type="file" name="image">
                            <span class="error"><?php echo $errors['image'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset class="fieldset-row">
                            <label for="description">Description:</label>
                            <textarea name="description" class="description-editor" placeholder="Description"><?= htmlspecialchars($disease['description'] ?? '') ?></textarea>
                            <span class="error"><?php echo $errors['description'] ?? ''; ?></span>
                        </fieldset>
                        <span class="error"><?php echo $errors['database'] ?? ''; ?></span>
                        <input type="submit" class="form-submit" value="Update Disease">
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
