<?php
$items = get_active_portfolio($pdo);
?>

<main>
    <h2>Referenciák</h2>
    <?php if(empty($items)): ?>
        <p>Jelenleg nincsenek refernciák</p>
    <?php else: ?>
        <ul>
            <?php foreach($items as $item): ?>
                <li>
                    <strong><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></strong><br>
                    <?php echo nl2br(htmlspecialchars($item['short_description'], ENT_QUOTES, 'UTF-8')); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>