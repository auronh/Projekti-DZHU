<header>
    <a href="index.php" class="logo"><?php echo SITE_NAME; ?></a>
    <nav>
        <a href="index.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <?php if (isLoggedIn()): ?>
            <?php if (isAdmin()): ?>
                <a href="../admin/dashboard.php" style="color: var(--accent);">Dashboard</a>
            <?php endif; ?>
            <a href="logout.php" style="border: 2px solid white; padding: 5px 10px; border-radius: 10px;">
                Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)
            </a>
        <?php else: ?>
            <a href="login.php" style="border: 2px solid white; padding: 5px 10px; border-radius: 10px;">Login</a>
            <a href="register.php" style="border: 2px solid white; padding: 5px 10px; border-radius: 10px;">Register</a>
        <?php endif; ?>
    </nav>
</header>
