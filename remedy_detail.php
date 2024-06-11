<?php 
include('./assets/queries/remedy_detail.php'); 
?>
<!DOCTYPE html>
<html lang="en">

<?php
$page_title = htmlspecialchars($data['name']);
$css_path = "./assets/css/remedy_detail.css";
include './layout/head.php';
?>

<body>
    <?php include './layout/header.php'; ?>

    <section>
        <div class="flex">
            <div class="left">
                <div class="main_image">
                    <img src="<?= htmlspecialchars($images[0]) ?>" alt="" class="slide">
                </div>
                <div class="option flex">
                    <?php foreach ($images as $image) { ?>
                        <img src="<?= htmlspecialchars($image) ?>" onclick="img('<?= htmlspecialchars($image) ?>')">
                    <?php } ?>
                </div>
            </div>
            <div class="right">
                <?php if (!empty($data['introduction'])) { ?>
                    <h2><?= $data['name'] ?>'s Introduction:</h2>
                    <p><?= $data['introduction'] ?></p>
                <?php } ?>

                <?php if (!empty($data['advantages'])) { ?>
                    <h2>Advantages of <?= $data['name'] ?>:</h2>
                    <p><?= $data['advantages'] ?></p>
                <?php } ?>

                <?php if (!empty($data['dis_advantages'])) { ?>
                    <h2>Disadvantages of <?= $data['name'] ?>:</h2>
                    <p><?= $data['dis_advantages'] ?></p>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php include './layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./assets/js/remedy_detail.js"></script>
    <script src="./assets/js/header.js"></script>
</body>

</html>
