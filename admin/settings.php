<?php
declare(strict_types=1);

session_start();

require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/db.php';
require __DIR__ . '/../app/auth.php';

$pdo = get_pdo();
admin_login();

$message = '';

// --- Feldolgozás (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['homepage_title'] ?? '');
    $subtitle = trim($_POST['homepage_subtitle'] ?? '');
    $about    = trim($_POST['homepage_about'] ?? '');

    // Egyszerű update: minden kulcshoz külön UPDATE
    $stmt = $pdo->prepare("UPDATE settings SET value = :value WHERE key_name = :key");

    $stmt->execute([
        'key'   => 'homepage_title',
        'value' => $title,
    ]);

    $stmt->execute([
        'key'   => 'homepage_subtitle',
        'value' => $subtitle,
    ]);

    $stmt->execute([
        'key'   => 'homepage_about',
        'value' => $about,
    ]);

    $message = 'Főoldali szövegek frissítve.';
}

// --- Aktuális értékek betöltése ---
$stmt = $pdo->query("SELECT key_name, value FROM settings");
$rows = $stmt->fetchAll();

$settings = [];
foreach ($rows as $row) {
    $settings[$row['key_name']] = $row['value'];
}

require __DIR__ . '/../public/templates/admin_header.php';
?>

<h1>Főoldal szövegeinek szerkesztése</h1>

<?php if ($message): ?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php endif; ?>

<form method="post" class="mb-4">
    <div class="mb-3">
        <label class="form-label">Főoldali cím</label>
        <input type="text"
               name="homepage_title"
               class="form-control"
               value="<?php echo htmlspecialchars($settings['homepage_title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Főoldali alcím</label>
        <textarea name="homepage_subtitle"
                  class="form-control"
                  rows="2"><?php echo htmlspecialchars($settings['homepage_subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Bemutatkozó szöveg</label>
        <textarea name="homepage_about"
                  class="form-control"
                  rows="5"><?php echo htmlspecialchars($settings['homepage_about'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Mentés</button>
</form>

<?php
require __DIR__ . '/../public/templates/admin_footer.php';
