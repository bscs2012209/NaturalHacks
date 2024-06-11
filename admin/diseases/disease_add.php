<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../../connection.php';

$name = '';
$description = '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');

    // Validate Name
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }
    
    // Validate Image
    if (empty($_FILES['image']['name'])) {
        $errors['image'] = 'Image is required';
    } else {
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
    }

    // Validate Description
    if (empty($description)) {
        $errors['description'] = 'Description is required';
    }

    // If there are no validation errors, proceed with database insertion
    if (empty($errors)) {
        $insertSql = "INSERT INTO `diseases` (
            `name`,
            `image`,
            `description`
        ) VALUES (
            '$name',
            '$imagePath',
            '$description'
        )";

        $response = mysqli_query($conn, $insertSql);

        if ($response) {
            header("Location: ./diseases.php");
            exit();
        } else {
            $errors['database'] = 'Failed to insert data into the database';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Add Disease';
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
                    <h2 class="page-heading">Add Disease</h2>

                    <form class="page-form" action="disease_add.php" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
                            <span class="error"><?= $errors['name'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset>
                            <label for="image">Image:</label>
                            <input type="file" name="image">
                            <span class="error"><?= $errors['image'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset class="fieldset-row">
                            <label for="description">Description:</label>
                            <textarea name="description" class="description-editor" placeholder="Description"><?= htmlspecialchars($description) ?></textarea>
                            <span class="error"><?= $errors['description'] ?? ''; ?></span>
                        </fieldset>
                        <span class="error"><?= $errors['database'] ?? ''; ?></span>
                        <input type="submit" class="form-submit" value="Add Disease">
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
