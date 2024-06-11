<header>
    <!-- Nav Container -->
    <div class="nav container">
        <!-- Menu Icon -->
        <i class='bx bx-menu' id="menu-icon"></i>
        <!-- Logo -->
        <a href="./index.php" class="logo">Natural<span>Hacks</span></a>
        <!-- Nav List -->
        <ul class="navbar">
            <?php foreach ($navbarItems as $item) { ?>
                <li><a href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>
                    </a></li>
            <?php } ?>
        </ul>
        <!-- Search & CartIcon -->
        <?php if ($header_icon['search'] == true) { ?>
            <i class='bx bx-search-alt-2' style="font-size: 1.5rem;" id="search-icon"></i>
        <?php } ?>
        <?php if (isset($_SESSION['is_user']) && $header_icon['cart'] == true) { ?>
            <i class='bx bx-cart-alt' style="font-size: 1.5rem;" onclick="openCart()"></i>
        <?php } ?>
        <!-- Search Box -->
        <div class="search-box container">
            <input type="search" onkeyup="searchCall(this.value)" name="" id="" placeholder="Search Here...">

            <div style="width: 80%; margin: 0 auto">
                <ul id="searchOptions">
                </ul>
            </div>
        </div>
    </div>
</header>
