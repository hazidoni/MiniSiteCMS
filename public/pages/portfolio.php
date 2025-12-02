<?php
$items = get_active_portfolio($pdo);
?>

<section>
    <h2 class="section-title">Referenciák</h2>

    <?php if (empty($items)): ?>
        <p>Jelenleg nincsenek rögzített referenciák.</p>
    <?php else: ?>
        <div class="row portfolio-grid">
            <?php foreach ($items as $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?>
                            </h5>
                            <p class="card-text">
                                <?php echo nl2br(htmlspecialchars($item['short_description'], ENT_QUOTES, 'UTF-8')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>