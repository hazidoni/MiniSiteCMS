<?php
$services = get_active_services($pdo);
?>
<main>
    <h2>Szolgáltatások</h2>
    <?php if (empty($services)): ?>
        <p>Jelenleg nincsenek rögzített Szolgáltatások.</p>
    <?php else: ?>
    <ul>
        <?php foreach ($services as $service): ?>
            <li>
                <strong><?php echo htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8'); ?></strong><br>
                <?php echo nl2br(htmlspecialchars($service['description'], ENT_QUOTES, 'UTF-8')); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</main>