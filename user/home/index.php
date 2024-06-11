<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['is_user'] !== 'user') {
    header("Location: ./login.php");
    exit();
}

require_once '../../connection.php';

$userId = isset($_SESSION['user_id']) ? mysqli_real_escape_string($conn, $_SESSION['user_id']) : null;

$sql = "SELECT COUNT(id) AS order_count FROM orders WHERE user_id = '$userId'";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    die("Error in query: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$userOrderCount = $row['order_count'];

?>
<!DOCTYPE html>
<html lang="en">
<?php
$page_title = 'Home';
include('../layout/head.php');
?>

<body>
    <input type="checkbox" id="menu-toggle">
    <?php
    include('../layout/sidebar.php');
    ?>

    <div class="main-content">

        <?php
        include('../layout/header.php');
        ?>

        <main>

            <div class="page-header">
                <h3>Welcome </h3>
            </div>

            <div class="page-content">

                <div class="analytics">

                    <div class="analytic-card first-analytic-card" style="background-image: linear-gradient(45deg, #22baa0, #93edde, #22baa0);">
                        <div class="analytic-card-left">
                            <span class="las la-shopping-cart" style="font-size: 4rem; margin: 1rem;"></span>

                        </div>

                        <div class="analytic-card-right">
                            <h1 style="font-size: 4rem;"><?= $userOrderCount ?></h1>
                            <span>Total Orders</span>
                        </div>
                    </div>
                    <div></div>

                </div>

            </div>

        </main>

    </div>
</body>

</html>