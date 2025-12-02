<?php
$services = get_active_services($pdo);
?>
<section>
    <h2 class="section-title">Szolgáltatások</h2>

    <?php if (empty($services)): ?>
        <p>Jelenleg nincsenek rögzített szolgáltatások.</p>
    <?php else: ?>
        <div class="row services-grid">
            <?php foreach ($services as $service): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8'); ?>
                            </h5>
                            <p class="card-text">
                                <?php echo nl2br(htmlspecialchars($service['description'], ENT_QUOTES, 'UTF-8')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>