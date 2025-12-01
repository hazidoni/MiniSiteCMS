<?php
    declare(strict_types=1);

    session_start();

    require __DIR__ . '/../app/db.php';
    require __DIR__ . '/../app/config.php';
    require __DIR__ . '/../app/auth.php';

    $pdo = get_pdo();

    admin_login();

    require __DIR__ . '/../public/templates/admin_header.php';
?>

    <h1>Admin felület</h1>
    <p>Üdv, <?php echo htmlspecialchars($_SESSION['admin_username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>!</p>

    <ul>
        <li><a href="services.php">Szolgáltatások kezelése</a></li>
        <li><a href="portfolio.php">Referenciák kezelése</a></li>
        <li><a href="settings.php">Főoldal szövegek szerkesztése</a></li>
    </ul>
<?php
require __DIR__ . '/../public/templates/admin_footer.php';
?>