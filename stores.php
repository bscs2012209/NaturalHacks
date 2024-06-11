<?php 
include './assets/queries/stores.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'Stores';
$css_path = "./assets/css/invoice.css"; // Changed the page title to 'Stores'
include './layout/head.php';
?>

<body>
    <?php include './layout/header.php'; ?>
  
    <div class="container" style="width: 80%; margin: 10rem auto;">
        <h2>Our Stores</h2>
        <ul class="store-list" style="list-style: none;">
            <?php foreach($stores as $store): ?>
                <li style="border-bottom: 1px solid gray; padding: 1rem;">
                    <div class="store-info">
                        <h3><?= htmlspecialchars($store['name']) ?></h3>
                        <p><?= htmlspecialchars($store['address']) ?></p>
                    </div>
                    <div class="store-map" style="padding: 0.5rem;">
                        <a style="background-color: green; border-radius: 0.25rem; padding: 0.5rem; max-width: 10rem; text-align: center; color: white" href="<?= 'https://maps.google.com/?q='.$store['latitude'].','.$store['longitude'] ?>" target="_blank">
                            View on Map
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php include './layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./assets/js/remedy_detail.js"></script>
    <script src="./assets/js/header.js"></script>

</body>

</html>
