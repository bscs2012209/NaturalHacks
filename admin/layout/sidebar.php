<div class="sidebar">
    <div class="side-header">
        <img src="../assets/logo/logo-nobg.png" width="100%" alt="">
    </div>

    <div class="side-content">
    <div class="profile">
            <div class="profile-left-section">
                <img src="<?= htmlspecialchars($_SESSION['admin_image']) ?>" alt="Profile Image">
            </div>
            <div class="profile-right-section">
                <span><?= htmlspecialchars($_SESSION['admin_name']) ?></span>
                <small><?= htmlspecialchars($_SESSION['admin_email']) ?></small>
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
                    <a href="../users/users.php" <?= (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'class="active"' : ''; ?>>
                        <div class="menu-item-icon">
                            <span class="las la-users"></span>
                        </div>
                        <div class="menu-item-label">
                            <small>Users</small>
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../remedies/remedies.php" <?= (basename($_SERVER['PHP_SELF']) == 'remedies.php') ? 'class="active"' : ''; ?>>
                        <div class="menu-item-icon">
                            <span class="las la-leaf"></span>
                        </div>
                        <div class="menu-item-label">
                            <small>Remedies</small>
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../diseases/diseases.php" <?= (basename($_SERVER['PHP_SELF']) == 'diseases.php') ? 'class="active"' : ''; ?>>
                        <div class="menu-item-icon">
                            <span class="las la-frown"></span>
                        </div>
                        <div class="menu-item-label">
                            <small>Disease</small>
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../stores/stores.php" <?= (basename($_SERVER['PHP_SELF']) == 'stores.php') ? 'class="active"' : ''; ?>>
                        <div class="menu-item-icon">
                            <span class="las la-store"></span>
                        </div>
                        <div class="menu-item-label">
                            <small>Stores</small>
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../orders/orders.php" <?= (basename($_SERVER['PHP_SELF']) == 'orders.php') ? 'class="active"' : ''; ?>>
                        <div class="menu-item-icon">
                            <span class="las la-shopping-cart"></span>
                        </div>
                        <div class="menu-item-label">
                            <small>Orders</small>
                        </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../discounts/discounts.php" <?= (basename($_SERVER['PHP_SELF']) == 'discounts.php') ? 'class="active"' : ''; ?>>
                        <div class="menu-item-icon">
                        <span class="las la-tags"></span>
                        </div>
                        <div class="menu-item-label">
                            <small>Discounts</small>
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