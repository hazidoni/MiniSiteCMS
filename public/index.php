<?php

    declare(strict_types=1);

    require __DIR__ . '/../app/config.php';
    require __DIR__ . '/../app/db.php';
    require __DIR__ . '/../app/frontend.php';

    $pdo = get_pdo();

    $page = $_GET['page'] ?? 'home';

    $allowedPages = ['home', 'services', 'portfolio', 'contact'];

    if(!in_array($page, $allowedPages, true)) {
        $page = 'home';
    }

    $pageFile = __DIR__ . '/pages/' . $page . '.php';

    $subtitle = "Első PHP alapú bemutató oldalam";

    // header
    require __DIR__ . '/templates/header.php';

    require $pageFile;

    require __DIR__ . '/templates/footer.php';
?>

