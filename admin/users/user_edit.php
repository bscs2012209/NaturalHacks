<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

    if (!$id) {
        die('Invalid ID');
    }

    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $price = isset($_POST['price']) ? mysqli_real_escape_string($conn, $_POST['price']) : '';
    $expert_id = isset($_POST['expert_id']) ? mysqli_real_escape_string($conn, $_POST['expert_id']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
    $introduction = isset($_POST['introduction']) ? mysqli_real_escape_string($conn, $_POST['introduction']) : '';
    $advantages = isset($_POST['advantages']) ? mysqli_real_escape_string($conn, $_POST['advantages']) : '';
    $disadvantages = isset($_POST['disadvantages']) ? mysqli_real_escape_string($conn, $_POST['disadvantages']) : '';

    if (!empty($_FILES['image']['name'])) {
        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/FypProject/assets/uploaded_images/remedies/';
        $imageName = str_replace([' ', ':'], '-', time() . '_' . basename($_FILES['image']['name']));
        $imageMove =  $uploadDirectory . $imageName;
        $imagePath = $_SERVER['HTTP_ORIGIN'] . '/FypProject/assets/uploaded_images/remedies/' . $imageName;

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imageMove)) {
            $updateImagePathSql = "UPDATE `remedies` SET `image` = '$imagePath' WHERE `id` = '$id'";
            mysqli_query($conn, $updateImagePathSql);
        }
    }


    $updateSql = "UPDATE `remedies` SET
        `name` = '$name',
        `price` = '$price',
        `expert_id` = " . ($expert_id !== '' ? "'$expert_id'" : 'NULL') . ",
        `description` = '$description',
        `introduction` = '$introduction',
        `advantages` = '$advantages',
        `dis_advantages` = '$disadvantages'
        WHERE `id` = '$id'";

    mysqli_query($conn, $updateSql);
}

$expertsSql = "SELECT * FROM `experts`";
$expertsResult = mysqli_query($conn, $expertsSql);
$expertsList = mysqli_fetch_all($expertsResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Edit User';
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
        $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

        if (!$id) {
            die('Invalid ID');
        }

        $sql = "SELECT * FROM `remedies` WHERE `id` = '$id'";
        $result = mysqli_query($conn, $sql);
        $remedy = mysqli_fetch_assoc($result);
        ?>

        <main>
            <div class="page-content">
                <div class="card">
                    <h2 class="page-heading">Edit Remedy</h2>

                    <form class="page-form" action="remedy_edit.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($remedy['name'] ?? '') ?>">
                        </fieldset>
                        <fieldset>
                            <label for="image">Image:</label>
                            <input type="file" name="image">
                        </fieldset>
                        <fieldset>
                            <label for="price">Price:</label>
                            <input type="number" name="price" value="<?= number_format($remedy['price'] ?? '', 2) ?>">
                        </fieldset>
                        <fieldset>
                            <label for="expert_id">Expert:</label>
                            <select name="expert_id">
                                <option value="">Select Expert</option>
                                <?php foreach ($expertsList as $expert) : ?>
                                    <option value="<?= $expert['id'] ?>" <?= ($remedy['expert_id'] ?? '') == $expert['id'] ? 'selected' : '' ?>>
                                        <?= $expert['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </fieldset>
                        <fieldset class="fieldset-row">
                            <label for="description">Description:</label>
                            <textarea name="description"><?= $remedy['description'] ?? '' ?></textarea>
                        </fieldset>
                        <fieldset class="fieldset-row">
                            <label for="introduction">Introduction:</label>
                            <textarea name="introduction" class="introduction-editor" placeholder="Introduction"><?= $remedy['introduction'] ?? '' ?></textarea>
                        </fieldset>
                        <fieldset class="fieldset-row">
                            <label for="advantages">Advantages:</label>
                            <textarea name="advantages" class="advantages-editor" placeholder="Advantages"><?= $remedy['advantages'] ?? '' ?></textarea>
                        </fieldset>
                        <fieldset class="fieldset-row">
                            <label for="disadvantages">Disadvantages:</label>
                            <textarea name="disadvantages" class="disadvantages-editor" placeholder="Disadvantages"><?= $remedy['dis_advantages'] ?? '' ?></textarea>
                        </fieldset>
                        <input type="submit" class="form-submit" value="Update Remedy">
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor.create(document.querySelector('.introduction-editor'))
            .catch(error => console.error(error));

        ClassicEditor.create(document.querySelector('.advantages-editor'))
            .catch(error => console.error(error));

        ClassicEditor.create(document.querySelector('.disadvantages-editor'))
            .catch(error => console.error(error));
    </script>
</body>

</html>