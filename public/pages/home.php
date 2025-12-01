<?php
    $home = get_homepage_content($pdo);

    $title = $home['homepage_title'];
    $subtitle = $home['homepage_subtitle'];
    $about = $home['homepage_about'];
?>


<main>
    <h2><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h2>
    <p>
        <?php echo htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8'); ?>
    </p>
    <p>
        <?php echo htmlspecialchars($about, ENT_QUOTES, 'UTF-8'); ?>
    </p>
</main>