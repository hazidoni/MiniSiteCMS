<?php
declare(strict_types=1);

session_start();

require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/db.php';
require __DIR__ . '/../app/auth.php';

$pdo = get_pdo();
admin_login();

$message = '';
$error   = '';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id                = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title             = trim($_POST['title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $sort_order        = (int)($_POST['sort_order'] ?? 0);
    $is_activate      = isset($_POST['is_activate']) ? 1 : 0;

    if ($title === '' || $short_description === '') {
        $error = 'A cím és a rövid leírás megadása kötelező.';
    } else {
        if ($id > 0) {
            
            $stmt = $pdo->prepare(
                "UPDATE portfolio
                 SET title = :title,
                     short_description = :short_description,
                     sort_order = :sort_order,
                     is_activate = :is_activate
                 WHERE id = :id"
            );
            $stmt->execute([
                'title'             => $title,
                'short_description' => $short_description,
                'sort_order'        => $sort_order,
                'is_activate'      => $is_activate,
                'id'                => $id,
            ]);

            $message = 'Referencia frissítve.';

        } else {
            
            $stmt = $pdo->prepare(
                "INSERT INTO portfolio (title, short_description, sort_order, is_activate)
                 VALUES (:title, :short_description, :sort_order, :is_activate)"
            );
            $stmt->execute([
                'title'             => $title,
                'short_description' => $short_description,
                'sort_order'        => $sort_order,
                'is_activate'      => $is_activate,
            ]);

            $message = 'Új referencia létrehozva.';
        }
    }
}


if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete') {

    $id = (int)$_GET['id'];

    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM portfolio WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $message = 'Referencia törölve.';
    }
}


$editItem = null;

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'edit') {

    $id = (int)$_GET['id'];

    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM portfolio WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $editItem = $stmt->fetch();
    }
}


$stmt = $pdo->query("SELECT * FROM portfolio ORDER BY sort_order ASC, created_at DESC");
$items = $stmt->fetchAll();

require __DIR__ . '/../public/templates/admin_header.php';
?>

<h1>Referenciák kezelése</h1>

<?php if ($message): ?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">

        <h2><?php echo $editItem ? 'Referencia szerkesztése' : 'Új referencia'; ?></h2>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo (int)($editItem['id'] ?? 0); ?>">

            <div class="mb-3">
                <label class="form-label">Cím</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="<?php echo htmlspecialchars($editItem['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Rövid leírás</label>
                <textarea name="short_description"
                          class="form-control"
                          rows="4"><?php echo htmlspecialchars($editItem['short_description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Sorrend</label>
                <input type="number"
                       name="sort_order"
                       class="form-control"
                       value="<?php echo (int)($editItem['sort_order'] ?? 0); ?>">
            </div>

            <div class="form-check mb-3">
                <input type="checkbox"
                       name="is_activate"
                       class="form-check-input"
                       id="is_activated"
                    <?php
                    $checked =
                        $editItem ? (!empty($editItem['is_activate']))
                                  : true;
                    echo $checked ? 'checked' : '';
                    ?>>
                <label class="form-check-label" for="is_activate">Aktív</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <?php echo $editItem ? 'Mentés' : 'Létrehozás'; ?>
            </button>

            <?php if ($editItem): ?>
                <a href="portfolio.php" class="btn btn-secondary ms-2">Mégse / Új hozzáadása</a>
            <?php endif; ?>
        </form>

    </div>

    <div class="col-md-6">

        <h2>Referenciák listája</h2>

        <?php if (!$items): ?>
            <p>Nincsenek rögzített referenciák.</p>
        <?php else: ?>
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Cím</th>
                    <th>Aktív</th>
                    <th>Sorrend</th>
                    <th>Műveletek</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo (int)$item['id']; ?></td>
                        <td><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo $item['is_activate'] ? 'Igen' : 'Nem'; ?></td>
                        <td><?php echo (int)$item['sort_order']; ?></td>
                        <td>
                            <a class="btn btn-sm btn-primary"
                               href="portfolio.php?action=edit&id=<?php echo (int)$item['id']; ?>">
                                Szerkesztés
                            </a>
                            <a class="btn btn-sm btn-danger"
                               href="portfolio.php?action=delete&id=<?php echo (int)$item['id']; ?>"
                               onclick="return confirm('Biztosan törlöd ezt a referenciát?');">
                                Törlés
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        <?php endif; ?>

    </div>
</div>

<?php
require __DIR__ . '/../public/templates/admin_footer.php';
