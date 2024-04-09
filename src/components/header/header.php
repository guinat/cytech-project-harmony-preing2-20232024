<header>
    <span>Header</span>
    <?php
    if (isset($_SESSION['user_id'])) : ?>
        <a href="/src/security/logout.php" class="font-bold text-fuchsia-900">Log Out</a>
    <?php else : ?>
        <a href="/templates/pages/sign-in.php" class="font-bold text-emerald-900">Sign In</a>
    <?php endif; ?>
</header>