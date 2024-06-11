<?php
session_start();
require_once '../../connection.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$errors = [];

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$id) {
    die('Invalid ID');
}

$sql = "SELECT * FROM `remedies` WHERE `id` = '$id'";
$result = mysqli_query($conn, $sql);
$remedy = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $price = mysqli_real_escape_string($conn, $_POST['price'] ?? '');
    $introduction = mysqli_real_escape_string($conn, $_POST['introduction'] ?? '');
    $advantages = mysqli_real_escape_string($conn, $_POST['advantages'] ?? '');
    $disadvantages = mysqli_real_escape_string($conn, $_POST['disadvantages'] ?? '');
    $disease_id = (int)$_POST['disease_id'] ?? '';
    $featured = (int)$_POST['featured'] ?? 0;
    $shelflife = (int)$_POST['shelflife'] ?? 0;
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients'] ?? '');
    $how_to_make = mysqli_real_escape_string($conn, $_POST['how_to_make'] ?? '');

    if (empty($errors)) {
        $imagePaths = [];
        $imagesJson = '';

        if (!empty($_FILES['images']['name'][0])) {
            $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/FypProject/assets/uploaded_images/remedies/';
            foreach ($_FILES['images']['name'] as $key => $imageName) {
                $imageName = str_replace([' ', ':'], '-', time() . '_' . basename($imageName));
                $imageMove = $uploadDirectory . $imageName;
                $imagePath = $_SERVER['HTTP_ORIGIN'] . '/FypProject/assets/uploaded_images/remedies/' . $imageName;

                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0755, true);
                }

                move_uploaded_file($_FILES['images']['tmp_name'][$key], $imageMove);

                $imagePaths[] = $imagePath;
            }
            $imagesJson = json_encode($imagePaths);
        } else {
            $imagesJson = $remedy['images'] ?? '';
        }

        $query = "UPDATE `remedies` SET ";
        $updateFields = [];

        if (!empty($name)) {
            $updateFields[] = "`name` = '$name'";
        }

        if (!empty($price)) {
            $updateFields[] = "`price` = '$price'";
        }

        if (!empty($introduction)) {
            $updateFields[] = "`introduction` = '$introduction'";
        }

        if (!empty($advantages)) {
            $updateFields[] = "`advantages` = '$advantages'";
        }

        if (!empty($disadvantages)) {
            $updateFields[] = "`dis_advantages` = '$disadvantages'";
        }

        if (!empty($disease_id)) {
            $updateFields[] = "`disease_id` = '$disease_id'";
        }

        if (!empty($featured)) {
            $updateFields[] = "`featured` = '$featured'";
        }

        if (!empty($shelflife)) {
            $updateFields[] = "`shelflife` = '$shelflife'";
        }

        if (!empty($ingredients)) {
            $updateFields[] = "`ingredients` = '$ingredients'";
        }

        if (!empty($how_to_make)) {
            $updateFields[] = "`how_to_make` = '$how_to_make'";
        }

        if (!empty($imagesJson)) {
            $updateFields[] = "`images` = '$imagesJson'";
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
}

$diseasesSql = "SELECT * FROM `diseases`";
$diseasesResult = mysqli_query($conn, $diseasesSql);
$diseasesList = mysqli_fetch_all($diseasesResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<?php
$page_title = 'Edit Remedy';
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
                    <h2 class="page-heading">Edit Remedy</h2>
                    <span class="error"><?php echo $errors['database'] ?? ''; ?></span>
                    <form class="page-form" action="remedy_edit.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
                        <fieldset>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($remedy['name'] ?? '') ?>">
                            <span class="error"><?php echo $errors['name'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset>
                            <label for="images">Images:</label>
                            <input type="file" name="images[]" multiple>
                            <span class="error"><?php echo $errors['images'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset>
                            <label for="price">Price:</label>
                            <input type="number" name="price" value="<?= htmlspecialchars($remedy['price']) ?>">
                            <span class="error"><?php echo $errors['price'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset style="display: inline-block;">
                            <legend>Featured:</legend>
                            <input type="radio" class="featured" id="featured_no" name="featured" value="0" <?php if ($remedy['featured'] == 0) { echo 'checked';} ?>>
                            <label for="featured_no">Remedy</label>
                            <input type="radio" class="featured" id="featured_yes" name="featured" value="1" <?php if ($remedy['featured'] == '1') { echo 'checked';} ?>>
                            <label for="featured_yes">Herb</label>
                        </fieldset>
                        <fieldset style="display: inline-block;">
                            <legend>ShelfLife:</legend>
                            <input type="radio" id="shelflife_no" name="shelflife" value="0" <?php if ($remedy['shelflife'] == 0) { echo 'checked';} ?>>
                            <label for="shelflife_no">No</label>
                            <input type="radio" id="shelflife_yes" name="shelflife" value="1" <?php if ($remedy['shelflife'] == '1') { echo 'checked';} ?>>
                            <label for="shelflife_yes">Yes</label>
                        </fieldset>
                        <fieldset class="fieldset-row Disease">
                            <label for="disease_id">Disease:</label>
                            <select name="disease_id">
                                <option value="0">Select Disease</option>
                                <?php foreach ($diseasesList as $disease) { ?>
                                    <option value="<?= $disease['id'] ?>" <?= ($remedy['disease_id'] ?? '') == $disease['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($disease['name']) ?>
                                    </option>
                                <?php }; ?>
                            </select>
                            <span class="error"><?php echo $errors['disease_id'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset class="fieldset-row ingredients">
                            <label for="ingredients">Ingredients:</label>
                            <textarea name="ingredients" class="ingredients-editor" placeholder="Ingredients"><?= htmlspecialchars($remedy['ingredients'] ?? '') ?></textarea>
                            <span class="error"><?php echo $errors['ingredients'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset class="fieldset-row How_To_Make">
                            <label for="how_to_make">How To Make:</label>
                            <textarea name="how_to_make" class="how_to_make-editor" placeholder="How To Make"><?= htmlspecialchars($remedy['how_to_make'] ?? '') ?></textarea>
                            <span class="error"><?php echo $errors['how_to_make'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset class="fieldset-row introduction">
                            <label for="introduction">Introduction:</label>
                            <textarea name="introduction" class="introduction-editor" placeholder="Introduction"><?= htmlspecialchars($remedy['introduction'] ?? '') ?></textarea>
                            <span class="error"><?php echo $errors['introduction'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset class="fieldset-row advantages">
                            <label for="advantages">Advantages:</label>
                            <textarea name="advantages" class="advantages-editor" placeholder="Advantages"><?= htmlspecialchars($remedy['advantages'] ?? '') ?></textarea>
                            <span class="error"><?php echo $errors['advantages'] ?? ''; ?></span>
                        </fieldset>
                        <fieldset class="fieldset-row disadvantages">
                            <label for="disadvantages">DisAdvantages:</label>
                            <textarea name="disadvantages" class="disadvantages-editor" placeholder="DisAdvantages"><?= htmlspecialchars($remedy['dis_advantages'] ?? '') ?></textarea>
                            <span class="error"><?php echo $errors['disadvantages'] ?? ''; ?></span>
                        </fieldset>
                            <input type="submit" class="form-submit" value="Update Remedy">
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('.ingredients-editor'))
            .catch(error => console.error(error));

        ClassicEditor.create(document.querySelector('.how_to_make-editor'))
            .catch(error => console.error(error));

        ClassicEditor.create(document.querySelector('.introduction-editor'))
            .catch(error => console.error(error));

        ClassicEditor.create(document.querySelector('.advantages-editor'))
            .catch(error => console.error(error));

        ClassicEditor.create(document.querySelector('.disadvantages-editor'))
            .catch(error => console.error(error));

        function updateDisplay(featured) {
            if (featured == 1) {
                document.querySelector('.introduction').style.display = 'block';
                document.querySelector('.DisAdvantages').style.display = 'block';
                document.querySelector('.ingredients').style.display = 'none';
                document.querySelector('.How_To_Make').style.display = 'none';
                document.querySelector('.Disease').style.display = 'none';
            } else {
                document.querySelector('.introduction').style.display = 'none';
                document.querySelector('.DisAdvantages').style.display = 'none';
                document.querySelector('.ingredients').style.display = 'block';
                document.querySelector('.How_To_Make').style.display = 'block';
                document.querySelector('.Disease').style.display = 'flex';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var selectedValue = document.querySelector('.featured:checked').value;
            updateDisplay(selectedValue);
        });

        function featured_change(e) {
            updateDisplay(e.value);
        }
    </script>
</body>
</html>
