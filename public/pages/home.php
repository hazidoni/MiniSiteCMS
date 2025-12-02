<?php
    $home = get_homepage_content($pdo);

    $title = $home['homepage_title'];
    $subtitle = $home['homepage_subtitle'];
    $about = $home['homepage_about'];
?>


<div class="hero mb-5">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h1 class="mb-3"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
            <?php if ($subtitle): ?>
                <p class="lead mb-4">
                    <?php echo nl2br(htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8')); ?>
                </p>
            <?php endif; ?>
            <a href="index.php?page=services" class="btn btn-light btn-lg me-2">
                Szolgáltatások megtekintése
            </a>
            <a href="index.php?page=portfolio" class="btn btn-light btn-lg">
                Referenciák
            </a>
        </div>
        <div class="col-md-5 mt-4 mt-md-0 text-md-end">
            <span class="badge bg-light text-dark mb-2">PHP · MySQL · Admin</span>
        </div>
    </div>
</div>

<?php if ($about): ?>
    <section class="mb-4">
        <h2 class="section-title">Rólam / rólunk</h2>
        <p><?php echo nl2br(htmlspecialchars($about, ENT_QUOTES, 'UTF-8')); ?></p>
    </section>
<?php endif; ?>