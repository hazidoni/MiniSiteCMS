<?php
declare(strict_types=1);
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Admin - MiniSiteCMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Admin</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="services.php">Szolgáltatások</a></li>
                <li class="nav-item"><a class="nav-link" href="portfolio.php">Referenciák</a></li>
                <li class="nav-item"><a class="nav-link" href="settings.php">Főoldal szövegek</a></li>
            </ul>
            <span class="navbar-text me-3">
                <?php echo htmlspecialchars($_SESSION['admin_username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
            </span>
            <a class="btn btn-outline-light btn-sm" href="logout.php">Kijelentkezés</a>
        </div>
    </div>
</nav>
<div class="container">
