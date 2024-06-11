<div class="sidebar">
    <div class="side-header">
        <img src="../assets/logo/logo-nobg.png" width="100%" alt="">
    </div>

    <div class="side-content">
        <div class="profile">
            <div class="profile-left-section">
                <img src="<?= htmlspecialchars(mysqli_real_escape_string($conn, $_SESSION['expert_image'])) ?>" alt="">
            </div>
            <div class="profile-right-section">
                <span><?= htmlspecialchars(mysqli_real_escape_string($conn, $_SESSION['expert_name'])) ?></span>
                <small><?= htmlspecialchars(mysqli_real_escape_string($conn, $_SESSION['expert_email'])) ?></small>
            </div>
        </div>

        <div class="side-menu">
            <ul>
                <li class="menu-item">
                    <a href="../dashboard/index.php" <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : ''; ?>>
                        <div class="menu-item-icon">
                            <span class="las la-home"></span>
                        </div>
                        <div class="menu-item-label">
                            <small>Dashboard</small>
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../remedies/remedies.php" <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : ''; ?>>
                        <div class="menu-item-icon">
                            <span class="las la-leaf"></span>
                        </div>
                        <div class="menu-item-label">
                            <small>Remedies</small>
                        </div>
                    </a>
                </li>

                <li class="menu-item logout">
                    <a href="../logout.php">
                        <div class="menu-item-icon">
                            <span class="las la-power-off"></span>
                        </div>
                        <div class="menu-item-label">
                            <small>Logout</small>
                        </div>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>