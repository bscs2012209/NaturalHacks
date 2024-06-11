<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['is_admin'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once '../../connection.php';

// Function to get counts for the last 7 days
function getCountsForLastDays($conn, $table, $dateColumn, $status = '') {
    $counts = [];
    for ($i = 0; $i < 7; $i++) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $whereClause = $status ? " AND expert_approval = '$status'" : '';
        $query = "SELECT COUNT(*) FROM $table WHERE DATE($dateColumn) = '$date' $whereClause";
        $result = mysqli_query($conn, $query);
        $counts[] = mysqli_fetch_row($result)[0];
    }
    return array_reverse($counts);
}

$userCount = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users"))[0];
$userCounts = getCountsForLastDays($conn, 'users', 'created_at');

$expertCount = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM experts"))[0];
$expertCounts = getCountsForLastDays($conn, 'experts', 'created_at');

$remedyCount = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM remedies"))[0];
$remedyCounts = getCountsForLastDays($conn, 'remedies', 'created_at');

$diseaseCount = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM diseases"))[0];
$diseaseCounts = getCountsForLastDays($conn, 'diseases', 'created_at');

$orderCount = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM orders"))[0];
$orderCounts = getCountsForLastDays($conn, 'orders', 'created_at');

$storeCount = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM stores"))[0];
$storeCounts = getCountsForLastDays($conn, 'stores', 'created_at');
?>

<!DOCTYPE html>
<html lang="en">
<?php
$page_title = 'Home';
include('../layout/head.php');
?>

<body>
    <input type="checkbox" id="menu-toggle">
    <?php include('../layout/sidebar.php'); ?>

    <div class="main-content">
        <?php include('../layout/header.php'); ?>
        <main>
            <div class="page-header">
                <h3>Dashboard</h3>
            </div>
            <div class="page-content">
                <div class="analytics">

                <div class="analytic-card first-analytic-card">
                        <div class="analytic-card-left">
                            <img src="../assets/images/users.png" style="width:5vw" alt="">
                            <h2><?= $userCount ?></h2>
                            <small>Total Users</small>
                        </div>

                        <div class="analytic-card-right">
                            <div class="chart-container" style="width: 15vw">
                                <canvas id="UserChart" style="width: 100%;"></canvas>
                            </div>
                            <span style="color: #56FD25;">+<?= array_sum($userCounts) ?></span><small style="font-size: x-small;">This Week</small>
                        </div>
                    </div>


                    <div class="analytic-card second-analytic-card">
                        <div class="analytic-card-left">
                            <img src="../assets/images/docters.png" style="width:5vw" alt="">
                            <h2><?= $expertCount ?></h2>
                            <small>Total Experts</small>
                        </div>

                        <div class="analytic-card-right">
                            <div class="chart-container" style="width: 15vw">
                                <canvas id="ExpertChart" style="width: 100%;"></canvas>
                            </div>
                            <span style="color: #56FD25;">+<?= array_sum($expertCounts) ?></span><small style="font-size: x-small;">This Week</small>
                        </div>
                    </div>



                    <div class="analytic-card third-analytic-card">
                        <div class="analytic-card-left">
                            <img src="../assets/images/leaf.png" style="width:5vw" alt="">
                            <h2><?= $remedyCount ?></h2>
                            <small>Total Remedies</small>
                        </div>

                        <div class="analytic-card-right">
                            <div class="chart-container" style="width: 15vw">
                                <canvas id="RemedyChart" style="width: 100%;"></canvas>
                            </div>
                            <span style="color: #56FD25;">+<?= array_sum($remedyCounts) ?></span><small style="font-size: x-small;">This Week</small>
                        </div>
                    </div>



                    <div class="analytic-card fourth-analytic-card">
                        <div class="analytic-card-left">
                            <img src="../assets/images/disease.png" style="width:5vw" alt="">
                            <h2><?= $diseaseCount ?></h2>
                            <small>Total Diseases</small>
                        </div>

                        <div class="analytic-card-right">
                            <div class="chart-container" style="width: 15vw">
                                <canvas id="DiseaseChart" style="width: 100%;"></canvas>
                            </div>
                            <span style="color: #56FD25;">+<?= array_sum($diseaseCounts) ?></span><small style="font-size: x-small;">This Week</small>
                        </div>
                    </div>



                    <div class="analytic-card fifth-analytic-card">
                        <div class="analytic-card-left">
                            <img src="../assets/images/box.png" style="width:5vw" alt="">
                            <h2><?= $orderCount ?></h2>
                            <small>Total Orders</small>
                        </div>

                        <div class="analytic-card-right">
                            <div class="chart-container" style="width: 15vw">
                                <canvas id="OrderChart" style="width: 100%;"></canvas>
                            </div>
                            <span style="color: #56FD25;">+<?= array_sum($orderCounts) ?></span><small style="font-size: x-small;">This Week</small>
                        </div>
                    </div>

                    <div class="analytic-card sixth-analytic-card">
                        <div class="analytic-card-left">
                            <img src="../assets/images/store.png" style="width:5vw" alt="">
                            <h2><?= $storeCount ?></h2>
                            <small>Total Stores</small>
                        </div>

                        <div class="analytic-card-right">
                            <div class="chart-container" style="width: 15vw">
                                <canvas id="StoreChart" style="width: 100%;"></canvas>
                            </div>
                            <span style="color: #56FD25;">+<?= array_sum($remedyCounts) ?></span><small style="font-size: x-small;">This Week</small>
                        </div>
                    </div>

                    
                
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    var userCounts = <?= json_encode($userCounts); ?>;
    var expertCounts = <?= json_encode($expertCounts); ?>;
    var remedyCounts = <?= json_encode($remedyCounts); ?>;
    var diseaseCounts = <?= json_encode($diseaseCounts); ?>;
    var orderCounts = <?= json_encode($orderCounts); ?>;
    var storeCounts = <?= json_encode($storeCounts); ?>;

    // Chart creation
    function createChart(ctx, data, borderColor) {
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Day 7', 'Day 6', 'Day 5', 'Day 4', 'Day 3', 'Day 2', 'Day 1'],
                datasets: [{
                    data: data,
                    borderWidth: 1,
                    borderColor: borderColor,
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    hidden: false,
                    tension: 0.4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    var userChart = createChart(document.getElementById('UserChart').getContext('2d'), userCounts, '#22baa0');
    var expertChart = createChart(document.getElementById('ExpertChart').getContext('2d'), expertCounts, '#11a8c3');
    var remedyChart = createChart(document.getElementById('RemedyChart').getContext('2d'), remedyCounts, '#30D100');
    var diseaseChart = createChart(document.getElementById('DiseaseChart').getContext('2d'), diseaseCounts, '#f25656');
    var orderChart = createChart(document.getElementById('OrderChart').getContext('2d'), orderCounts, '#fff23a');
    var storeChart = createChart(document.getElementById('StoreChart').getContext('2d'), storeCounts, '#34bcf1');
</script>
