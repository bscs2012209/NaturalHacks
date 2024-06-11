<?php
include './assets/queries/disease_detail.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php   
$page_title = $data['name'];
$css_path = "./assets/css/disease_detail.css";
include './layout/head.php';
?>

<body>
    <?php include './layout/header.php'; ?>
    <?php include './layout/cart.php'; ?>

    <section>
        <div class="flex">
            <div class="left">
                <div class="main_image">
                    <img src="<?= $data['image'] ?>" alt="" class="slide">
                </div>
            </div>
            <div class="right">
                <?php if (!empty($data['description'])) : ?>
                    <h2><?= $data['name']; ?>'s Description:</h2>
                    <p><?= $data['description'] ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="container herbs">
            <h2 class="title">Remedies</h2>
            <div class="products-container">
                <?php foreach ($remedies as $remedy) : ?>
                    <?php $images = json_decode($remedy['images'], true); ?>
                    <a href="./disease_remedy_detail.php?id=<?= $remedy['id'] ?>" class="product" data-name="p-1">
                        <img src="<?= $images[0] ?>" alt="">
                        <h3><?= $remedy['name'] ?></h3>
                        <div class="price">
                            <?php if ($discount) : ?>
                                <p><s style="text-decoration: line-through; text-decoration-color: red;">Rs.<?= $remedy['price'] ?></s></p>
                                <p>Rs. <?= checkDiscount($remedy['price'], $discount) ?></p>
                                <h5><?= $discount['name'] ?></h5>
                            <?php else : ?>
                                <div>Rs.<?= $remedy['price'] ?></div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include './layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./assets/js/disease_detail.js"></script>
    <script src="./assets/js/header.js"></script>
    <script src="./assets/js/cart.js"></script>
</body>
</html>
