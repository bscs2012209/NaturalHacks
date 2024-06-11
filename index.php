<?php
include './assets/queries/index.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = "Home";
$css_path = "./assets/css/index.css";
include './layout/head.php';
?>

<body>
    <?php include './layout/header.php'; ?>
    <?php include './layout/cart.php'; ?>
    <section class="home" id="home">
        <div class="swiper-container home-slider">
            <div class="slide-wrapper wrapper">
                <div class="home-text">
                    <h1>QUOTE OF THE <span> DAY!</span></h1>
                    <p>"Seek solace in the arms of nature, where <br> remedies grow and healing flourishes."<br> Unknown
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="remedy" id="remedy">
        <div class="heading">
            <h2><span>Commonly Used Herbs</span></h2>
        </div>
        <div class="remedy-container container">
            <?php foreach ($remedies as $row) {
                $images = json_decode($row['images'], true);
                ?>
                <div class="box">
                    <a href="./remedy_detail.php?id=<?= htmlspecialchars($row['id']) ?>"><img src="<?= htmlspecialchars($images[0]) ?>"></a>
                    <h2>
                        <?= htmlspecialchars($row["name"]) ?>
                    </h2>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class="remedy" id="suggestion">
        <div class="heading">
            <h2><span>Suggested Remedies</span></h2>
        </div>
        <div class="remedy-container container">
            <?php 

                foreach(json_decode($suggested) as $suggest) {
                    foreach($suggest->itemsets as $item){ 
                        $itemId = mysqli_real_escape_string($conn, $item);
                        $remedy = getRemedyDetail($itemId, $conn);
                        $images = json_decode($remedy['images'], true);
            ?>
                <div class="box">
                    <a href="./disease_remedy_detail.php?id=<?= htmlspecialchars($remedy['id']) ?>"><img src="<?= htmlspecialchars($images[0]) ?>"></a>
                    <h2>
                        <?= htmlspecialchars($remedy["name"]) ?>
                    </h2>
                </div>
            <?php 
                    }
                }   
            ?>
        </div>
    </section>

    <section class="about container" id="about">
        <div class="about-img">
            <img src="./assets/images/Herbs.jpg" alt="">
        </div>
        <div class="about-text">
            <span>About</span>
            <h2>Best Prices with <br>Quality Herbs</h2>
            <p>Natural Herbs is a platform that is solely dedicated to promoting health and wellness by offering natural
                remedies for various diseases and daily life challenges. We focus on providing remedies with a
                comprehensive approach and exploring the healing potential of nature.</p>
            <a href="./aboutus.php" class="btn">View More</a>
        </div>
    </section>

    <section class="categories" id="categories">
        <div class="heading">
            <span>What We Offer!</span>
            <h2>Our Remedies are Always Excellent</h2>
            <p>At Natural Hacks, we are committed to providing you with a holistic wellness platform that empowers you
                to
                embrace the healing power of nature.<br> Gain access to valuable information on natural healing methods,
                empowering you to make perfect choices for your well-being.</p>
        </div>
        <div class="categories-container container">
            <?php foreach ($diseases as $row) { ?>
                <div class="box">
                    <img src="<?= htmlspecialchars($row["image"]) ?>" alt="">
                    <h3>
                        <?= htmlspecialchars($row["name"]) ?>
                    </h3>
                    <a href="./disease_detail.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn">View Remedies</a>
                </div>
            <?php } ?>
        </div>
        <?php if (count($diseases) == 6) { ?>
            <div style="display: flex; justify-content:center;"><a href="diseases.php" class="btn"
                    style="border-radius: 10px;">view more</a></div>
        <?php } ?>
    </section>

    <?php include './layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./assets/js/header.js"></script>
</body>

</html>