<?php include './assets/queries/diseases.php'; ?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Diseases';
$css_path = "./assets/css/index.css";
include './layout/head.php';
?>

<body>
    <?php include './layout/header.php'; ?>

    <div class="categories-container container">
        <?php foreach ($diseases as $row): ?>
            <div class="box">
                <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
                <h3><?= $row['name'] ?></h3>
                <a href="./disease_detail.php?id=<?= $row['id'] ?>" class="btn">View Remedies</a>
            </div>
        <?php endforeach; ?>
    </div>

    <?php include './layout/footer.php'; ?>

    <script src="./assets/js/header.js"></script>
    <script src="./assets/js/cart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

</body>

</html>
