<?php
declare(strict_types=1);

session_start();

require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/db.php';
require __DIR__ . '/../app/auth.php';

$pdo = get_pdo();

admin_login();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = isset($_POST['id']) ? (int)$_POST['id']: 0;
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if($title === '' || $description === ''){
        $error = 'A cím és a leírást adja meg.';
    } else {
        if ($id > 0){
            $stmt = $pdo->prepare(
                "UPDATE services
                SET title = :title,
                description = :description,
                sort_order = :sort_order,
                is_active = :is_active
                WHERE id = :id"
            );
            $stmt -> execute([
                'title' => $title,
                'description' => $description,
                'sort_order' => $sort_order,
                'is_active' => $is_active,
                'id' => $id
            ]);
            $message = "Szolgáltalás $title frissítve.";
        } else {
            $stmt = $pdo -> prepare(
                "INSERT INTO services (title, description, sort_order, is_active)
                VALUES (:title, :description, :sort_order, :is_active)"
            );
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'sort_order' => $sort_order,
                'is_active' => $is_active,
            ]);
            $message = 'Új szolgáltatás létrehozva';
        }
    }
}

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete'){
    $id = (int)$_GET['id'];
    if ($id > 0){
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $message = "$id id-val rendelkező szolgáltatás törölve";
    }
}

$editService = null;

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'edit'){
    $id = (int)$_GET['id'];
    if ($id>0){
        $stmt = $pdo->prepare("SELECT * FROM services WHERE id = :id");
        $stmt -> execute(['id' => $id]);
        $editService = $stmt->fetch();
    }
}

$stmt = $pdo->query("SELECT * FROM services ORDER BY sort_order ASC, created_at DESC");
$services = $stmt->fetchAll();

require __DIR__ . '/../public/templates/admin_header.php';
?>

<h1>Szolgáltatások kezelése</h1>

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
        <h2><?php echo $editService ? 'Szolgáltatás szerkesztése' : 'Új szolgáltatás'; ?></h2>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo (int)($editService['id'] ?? 0); ?>">

            <div class="mb-3">
                <label class="form-label">Cím</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="<?php echo htmlspecialchars($editService['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Leírás</label>
                <textarea name="description"
                          class="form-control"
                          rows="4"><?php echo htmlspecialchars($editService['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Sorrend</label>
                <input type="number"
                       name="sort_order"
                       class="form-control"
                       value="<?php echo (int)($editService['sort_order'] ?? 0); ?>">
            </div>

            <div class="form-check mb-3">
                <input type="checkbox"
                       name="is_active"
                       class="form-check-input"
                       id="is_active"
                    <?php
                    $checked = $editService
                        ? (!empty($editService['is_active']))
                        : true;
                    echo $checked ? 'checked' : '';
                    ?>>
                <label class="form-check-label" for="is_active">Aktív</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <?php echo $editService ? 'Mentés' : 'Létrehozás'; ?>
            </button>

            <?php if ($editService): ?>
                <a href="services.php" class="btn btn-secondary ms-2">Mégse / Új hozzáadása</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="col-md-6">
        <h2>Szolgáltatások listája</h2>

        <?php if (!$services): ?>
            <p>Még nincsenek rögzített szolgáltatások.</p>
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
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo (int)$service['id']; ?></td>
                        <td><?php echo htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo $service['is_active'] ? 'Igen' : 'Nem'; ?></td>
                        <td><?php echo (int)$service['sort_order']; ?></td>
                        <td>
                            <a class="btn btn-sm btn-primary"
                               href="services.php?action=edit&id=<?php echo (int)$service['id']; ?>">
                                Szerkesztés
                            </a>
                            <a class="btn btn-sm btn-danger"
                               href="services.php?action=delete&id=<?php echo (int)$service['id']; ?>"
                               onclick="return confirm('Biztosan törlöd ezt a szolgáltatást?');">
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