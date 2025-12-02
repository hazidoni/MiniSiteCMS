<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Mini Ügyféloldal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Saját CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php?page=home">MiniSiteCMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-controls="mainNav"
                aria-expanded="false" aria-label="Navigáció váltása">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=home">Főoldal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=services">Szolgáltatások</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=portfolio">Referenciák</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=contact">Kapcsolat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/index.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="py-5">
    <div class="container">