<?php include './assets/queries/aboutus.php'; ?>

<!DOCTYPE html>
<html lang="en">

<?php
$page_title = 'About Us';
$css_path = "./assets/css/aboutus.css";
include './layout/head.php';
?>

<body>

    <?php include './layout/header.php'; ?>

    <div class="container-about">
        <div class="header">
            <h1>Our Team</h1>
        </div>
        <div class="sub-container-about">
            <div class="teams">
                <img src="./assets/images/team1.jpeg" alt="">
                <div class="name">Kashaf Khalid</div>
                <div class="desig">Student</div>
                <div class="aboutus">An enthusiastic student with various interpersonal skills looking out for
                    opportunities to enhance skills. Currently pursuing a bachelor's in computer science from Shaheed
                    Zulfiqar Ali Bhutto Institute of Technology.</div>

                <div class="social-links">
                    <a href="https://www.facebook.com/profile.php?id=100020108715061&mibextid=ZbWKwL"><i
                            class='bx bxl-facebook'></i></a>
                    <a href="https://x.com/KashafKhalid052?t=hQLdPQ60ujqE68QIQcFYEg&s=09"><i
                            class='bx bxl-twitter'></i></a>
                    <a href="https://instagram.com/kashaf_khalid512?igshid=OGQ5ZDc2ODk2ZA=="><i
                            class='bx bxl-instagram'></i></a>
                    <a href="https://www.linkedin.com/in/kashaf-khalid-47b20426b/"><i class='bx bxl-linkedin'></i></a>

                </div>
            </div>

            <div class="teams">
                <img src="./assets/images/team2.jpeg" alt="">
                <div class="name">Shannaya Murad</div>
                <div class="desig">Student</div>
                <div class="aboutus">A dedicated student acquiring quality education to sharpen her skills in order to
                    grow ethically and intellectually. Currently pursuing a bachelor's in computer science from Shaheed
                    Zulfiqar Ali Bhutto Institute of Technology.</div>

                <div class="social-links">
                    <a href="https://www.facebook.com/shanaya.fidai.77?mibextid=ZbWKwL"><i
                            class='bx bxl-facebook'></i></a>
                    <a href="https://x.com/Shanaya41564151?t=xVMKPHyO3whP6Mjnwh3sxA&s=09"><i
                            class='bx bxl-twitter'></i></a>
                    <a href="https://instagram.com/ishanayafidai757?igshid=MzMyNGUyNmU2YQ=="><i
                            class='bx bxl-instagram'></i></a>
                    <a href="https://www.linkedin.com/in/shannaya-fidai-6ab35324b/"><i class='bx bxl-linkedin'></i></a>

                </div>
            </div>
        </div>
    </div>

    <?php include './layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./assets/js/header.js"></script>

</body>

</html>
