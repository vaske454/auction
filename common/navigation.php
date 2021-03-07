<header>
    <nav class="navbar navbar-expand-sm navbar-inverse navbar-light bg-pale">
        <span class="navbar-brand">
            <a href="#">
                <img src="assets/images/logo.svg" alt="">
            </a>
        </span>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="view/my-account.php" class="nav-link">Account</a>
                </li>
                <li class="nav-item">
                    <a href="view/sell.php" class="nav-link">Sell</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <?php if(!$_SESSION['session']): ?>
                    <a href="view/login-view.php" class="nav-link">LogIn</a>
                    <?php else: ?>
                        <a href="?logout=true" class="nav-link">Log out</a>
                    <?php endif; ?>

                </li>
            </ul>
        </div>
    </nav>
</header>
