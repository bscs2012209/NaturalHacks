<?php include './assets/queries/disease_remedy_detail.php'; ?>

<?php
$page_title = $data['name'];
$css_path = "./assets/css/disease_remedy_detail.css";
include './layout/head.php';
?>

<body>
    <?php include './layout/header.php'; ?>
    <?php include './layout/cart.php'; ?>

    <section>
        <div class="flex">
            <div class="left">
                <div class="main_image">
                    <img src="<?= $images[0] ?>" alt="" class="slide">
                </div>
                <div class="option flex">
                    <?php foreach ($images as $image): ?>
                        <img src="<?= $image ?>" onclick="img('<?= $image ?>')">
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="right">
                <h1><?= $data['name'] ?></h1>

                <div class="display_star" style="display: flex;">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <img src="./assets/images/star.png" class="show-star" style="height: 1rem; width: 1rem; filter: <?= $i <= $data['rating'] ? 'grayscale(0%)' : 'grayscale(100%)' ?>">
                    <?php endfor; ?>
                    <small class="rating-name" style="padding-left: 1rem;">(<?= $data['rating'] ?>)</small>
                </div>

                <h4>
                    <?php if($discount): ?> 
                        <s style="text-decoration: line-through; text-decoration-color: red;">Rs.<?= $data['price'] ?></s> Rs. <?= checkDiscount($data['price'], $discount) ?>
                    <?php else: ?>        
                        Rs.<?= $data['price'] ?>
                    <?php endif; ?>
                </h4>

                <div style="display: flex; height: 8rem;">  
                    <div style="height: 100%; width: 60%; display: flex; flex-direction: column; gap: 0.5rem; padding: 0.5rem;">
                        <div style="background-color: #e0e0e0; width: 100%; height: 1rem; position: relative;">
                            <div style="background-color: #ffc107; width: <?= $ratings['total_reviews'] > 0 ? (($ratings['five_star']/$ratings['total_reviews'])*100) : 0 ?>%; height: 100%;"></div>
                        </div>
                        <div style="background-color: #e0e0e0; width: 100%; height: 1rem; position: relative;">
                            <div style="background-color: #ffc107; width: <?= $ratings['total_reviews'] > 0 ? (($ratings['four_star']/$ratings['total_reviews'])*100) : 0 ?>%; height: 100%;"></div>
                        </div>
                        <div style="background-color: #e0e0e0; width: 100%; height: 1rem; position: relative;">
                            <div style="background-color: #ffc107; width: <?= $ratings['total_reviews'] > 0 ? (($ratings['three_star']/$ratings['total_reviews'])*100) : 0 ?>%; height: 100%;"></div>
                        </div>
                        <div style="background-color: #e0e0e0; width: 100%; height: 1rem; position: relative;">
                            <div style="background-color: #ffc107; width: <?= $ratings['total_reviews'] > 0 ? (($ratings['two_star']/$ratings['total_reviews'])*100) : 0 ?>%; height: 100%;"></div>
                        </div>
                        <div style="background-color: #e0e0e0; width: 100%; height: 1rem; position: relative;">
                            <div style="background-color: #ffc107; width: <?= $ratings['total_reviews'] > 0 ? (($ratings['one_star']/$ratings['total_reviews'])*100) : 0 ?>%; height: 100%;"></div>
                        </div>
                    </div>
                    <div style="height: 100%; width: 40%; gap: 0.5rem; padding: 0.5rem; display: flex; flex-direction: column;">
                        <?php for ($i = 5; $i >= 1; $i--) : ?>
                            <div style="display: flex;">
                                <?php for ($j = 1; $j <= $i; $j++) : ?>
                                    <img src="./assets/images/star.png" style="height: 1rem; width: 1rem;">
                                <?php endfor; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php if (!empty($data['ingredients'])): ?>
                    <h2><?= $data['name'] ?>'s Ingredients:</h2>
                    <p><?= $data['ingredients'] ?></p>
                <?php endif; ?>

                <?php if (!empty($data['how_to_make'])): ?>
                    <h2>How To Make:</h2>
                    <p><?= $data['how_to_make'] ?></p>
                <?php endif; ?>

                <?php if (!empty($data['advantages'])): ?>
                    <h2>Advantages of <?= $data['name'] ?>:</h2>
                    <p><?= $data['advantages'] ?></p>
                <?php endif; ?>

                <div class="button-container">
                    <?php if (!isset($_SESSION['is_user']) && $data['shelflife'] == 0): ?>
                        <button class="cart" onclick="alert('You need to login')">Add to Cart</button>
                        <button class="cart" onclick="alert('You need to login')">Rate <?= $data['name'] ?></button>
                    <?php elseif(isset($_SESSION['is_user']) && $data['shelflife'] == 0): ?>
                        <?php
                        // Fetch user's address information
                        $user_id = $_SESSION['user_id'];
                        $address_query = "SELECT address FROM users WHERE id = $user_id";
                        $address_result = mysqli_query($conn, $address_query);
                        $user_address = mysqli_fetch_assoc($address_result)['address'];
                        ?>
                        <?php if (empty($user_address)): ?>
                            <button class="cart" onclick="alert('You need to provide an address, please update your profile.')">Add to Cart</button>
                        <?php else: ?>
                            <button class="cart" onclick="addToCart(<?= $data['id'] ?>)">Add to Cart</button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <?php if($user_id): ?>
                <div class="rating-box">
                    <div class="rating-box-head" style="border-bottom: 1px solid gray; margin-bottom: 1rem;">
                        <h1>Reviews & Rating</h1>
                        <small>Reviews and Rating about <?= $data['name'] ?>.</small>
                    </div>

                    <div class="rating-form">
                        <?php if ($rating_data && $user_id) : ?>
                            <h2>Your Rating</h2>
                            <small>Your rating about <?= $data['name'] ?>.</small>
                            <div class="display_star" style="display: flex;">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <img src="./assets/images/star.png" class="hover-star" style="height: 1rem; width: 1rem; filter: <?= $i <= ($rating_data ? $rating_data['rating'] : 0) ? 'grayscale(0%)' : 'grayscale(100%)' ?>">
                                <?php endfor; ?>
                                <small class="rating" style="padding-left: 1rem;">(<?= ($rating_data ? $rating_data['rating'] : 0) ?>)</small>
                            </div>
                            <span><?= $rating_data['description'] ?></span>
                        <?php elseif(!$rating_data && $user_id) : ?>
                            <h2>Give your Rating</h2>
                            <small>Please give your valuable reviews to <?= $data['name'] ?>.</small>
                            <form action="./disease_remedy_detail.php?id=<?= $id ?>" method="post" class="rating-box-body" style="display: flex; flex-direction: column;">
                                <div class="display_star" style="display: flex;">
                                    <input type="number" hidden name="rating_stars" class="rating_star">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <img src="./assets/images/star.png" class="hover-star" style="height: 1rem; width: 1rem; filter: <?= $i <= ($rating_data ? $rating_data['rating'] : 0) ? 'grayscale(0%)' : 'grayscale(100%)' ?>" onclick="mark_rating(<?= $i ?>)" onmouseover="show_rating(<?= $i ?>)" onmouseleave="hide_rating()">
                                    <?php endfor; ?>
                                    <small class="rating" style="padding-left: 1rem;">(<?= ($rating_data ? $rating_data['rating'] : 0) ?>)</small>
                                </div>
                                <textarea style="border: 1px solid	#C0C0C0; border-radius: 0.5rem; margin: 0.5rem 0; padding: 0.25rem;" name="rating_description" rows="3"></textarea>
                                <input style="background-color: green; color: white; border-radius: 0.5rem; border: none; padding: 0.5rem; margin: 0.5rem 0;" type="submit" value="Submit">
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="rating-form">
                        <h2>Other's Reviews</h2>
                        <?php foreach ($reviews_data as $review) : ?>
                            <div class="other-review" style="margin-bottom: 1rem;">
                                <div class="user-details">
                                    <img src="<?= $review['user_image'] ?? 'https://cdn-icons-png.flaticon.com/512/3177/3177440.png'?>" alt="<?= $review['user_name'] ?>" style="height: 1rem; width: 1rem; border-radius: 50%;">
                                    <small><?= $review['user_name'] ?></small>
                                </div>
                                <div class="review-content">
                                    <div class="display_star" style="display: flex;">
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <img src="./assets/images/star.png" class="users-star" style="height: 0.9rem; width: 0.9rem; filter: <?= $i <= $review['rating'] ? 'grayscale(0%)' : 'grayscale(100%)' ?>" >
                                        <?php endfor; ?>
                                        <small class="rating" style="padding-left: 1rem;">(<?= $review['rating'] ?>)</small>
                                    </div>    
                                    <p><?= $review['description'] ?></p>
                                    <small><?= date('F j, Y, g:i a', strtotime($review['created_at'])) ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="remedy-container container">
            <?php 
                $processedItems = []; 
                foreach(json_decode($suggested) as $suggest) {
                    foreach($suggest->itemsets as $item) {
                        if($item != $id && !in_array($item, $processedItems)) {
                            $remedy = getRemedyDetail($item, $conn);
                            $images = json_decode($remedy['images'], true);
                            $processedItems[] = $item;
            ?>
                        <div class="box">
                            <a href="./disease_remedy_detail.php?id=<?= $remedy['id'] ?>"><img src="<?= $images[0] ?>"></a>
                            <h2><?= $remedy["name"] ?></h2>
                        </div>
            <?php 
                        }
                    }
                }   
            ?>
        </div>
    </section>

    <?php include './layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./assets/js/disease_remedy_detail.js"></script>
    <script src="./assets/js/header.js"></script>
    <script src="./assets/js/cart.js"></script>
</body>

</html>
