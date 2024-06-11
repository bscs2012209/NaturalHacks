    <?php
    session_start();
    if (!isset($_SESSION['expert_id']) || $_SESSION['is_expert'] !== 'expert') {
        header("Location: ../login.php");
        exit();
    }
    require_once '../../connection.php';
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

            <?php

            function getCount($conn, $status)
            {
                if ($status === 'all') {
                    $remedyQuery = "SELECT COUNT(*) FROM remedies";
                } else {
                    $remedyQuery = "SELECT COUNT(*) FROM remedies WHERE expert_approval = '$status'";
                }
                
                $remedyResult = mysqli_query($conn, $remedyQuery);
                if ($remedyResult && mysqli_num_rows($remedyResult) > 0) {
                    return mysqli_fetch_row($remedyResult)[0];
                } else {
                    return 0;
                }
            }


            function getCounts($conn, $status)
            {
                $counts = array();
                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', strtotime("-$i days"));
                    if ($status === 'all') {
                        $query = "SELECT COUNT(*) FROM remedies WHERE DATE(created_at) = '$date'";
                    } else {
                        $query = "SELECT COUNT(*) FROM remedies WHERE DATE(created_at) = '$date' AND expert_approval = '$status'";
                    }
                    
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $counts[] = mysqli_fetch_row($result)[0];
                    } else {
                        $counts[] = 0;
                    }
                }
                return $counts;
            }


            $remedyCount = getCount($conn, 'all');
            $approvedRemedyCount = getCount($conn, 'approved');
            $declinedRemedyCount = getCount($conn, 'declined');
            $waitingRemedyCount = getCount($conn, 'waiting');

            $remedyCounts = getCounts($conn, 'all');
            $approvedCounts = getCounts($conn, 'approved');
            $declinedCounts = getCounts($conn, 'declined');
            $waitingCounts = getCounts($conn, 'waiting');

            ?>

            <main>
                <div class="page-header">
                    <h3>Dashboard</h3>
                </div>
                <div class="page-content">
                    <div class="analytics">
                        <div class="analytic-card first-analytic-card">
                            <div class="analytic-card-left">
                                <img src="../assets/images/total_remedies.png" style="width:5vw" alt="">
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


                        <div class="analytic-card second-analytic-card">
                            <div class="analytic-card-left">
                                <img src="../assets/images/approved.png" style="width:5vw" alt="">
                                <h2><?= $approvedRemedyCount ?></h2>
                                <small>Approved Remedies</small>
                            </div>

                            <div class="analytic-card-right">
                                <div class="chart-container" style="width: 15vw">
                                    <canvas id="ApprovedRemedyChart" style="width: 100%;"></canvas>
                                </div>
                                <span style="color: #56FD25;">+<?= array_sum($approvedCounts) ?></span><small style="font-size: x-small;">This Week</small>
                            </div>
                        </div>


                        <div class="analytic-card third-analytic-card">
                            <div class="analytic-card-left">
                                <img src="../assets/images/declined.png" style="width:5vw" alt="">
                                <h2><?= $declinedRemedyCount ?></h2>
                                <small>Declined Remedies</small>
                            </div>

                            <div class="analytic-card-right">
                                <div class="chart-container" style="width: 15vw">
                                    <canvas id="DeclinedRemedyChart" style="width: 100%;"></canvas>
                                </div>
                                <span style="color: #56FD25;">+<?= array_sum($declinedCounts) ?></span><small style="font-size: x-small;">This Week</small>
                            </div>
                        </div>


                        <div class="analytic-card fourth-analytic-card">
                            <div class="analytic-card-left">
                                <img src="../assets/images/pending.png" style="width:5vw" alt="">
                                <h2><?= $waitingRemedyCount ?></h2>
                                <small>Waiting Remedies</small>
                            </div>

                            <div class="analytic-card-right">
                                <div class="chart-container" style="width: 15vw">
                                    <canvas id="WaitingRemedyChart" style="width: 100%;"></canvas>
                                </div>
                                <span style="color: #56FD25;">+<?= array_sum($waitingCounts) ?></span><small style="font-size: x-small;">This Week</small>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var remedyCounts = <?= json_encode(array_reverse($remedyCounts)); ?>;
            var approvedCounts = <?= json_encode(array_reverse($approvedCounts)); ?>;
            var declinedCounts = <?= json_encode(array_reverse($declinedCounts)); ?>;
            var waitingCounts = <?= json_encode(array_reverse($waitingCounts)); ?>;

            function createChart(canvasId, data) {
                var ctx = document.getElementById(canvasId).getContext('2d');
                return new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Day 7', 'Day 6', 'Day 5', 'Day 4', 'Day 3', 'Day 2', 'Day 1'],
                        datasets: [{
                            data: data,
                            borderWidth: 1,
                            borderColor: '#30D100',
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

            createChart('RemedyChart', remedyCounts);
            createChart('ApprovedRemedyChart', approvedCounts);
            createChart('DeclinedRemedyChart', declinedCounts);
            createChart('WaitingRemedyChart', waitingCounts);
        </script>
    </body>

    </html>