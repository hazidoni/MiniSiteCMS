<?php
    declare(strict_types=1);

    session_start();

    require __DIR__ . '/../app/config.php';
    require __DIR__ . '/../app/db.php';
    require __DIR__ . '/../app/auth.php';

    $pdo = get_pdo();

    $error = '';
    $username = '';

    if (is_admin_logged_in()){
        header('Location: dashboard.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $error = 'Kérlek add meg a felhasználónevet és jelszót';
        } else {
            $user = find_admin_by_username($pdo, $username);

            if($user && password_verify($password, $user['password_hash'])){
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username']= $user['username'];

                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Hibás felhasználónév vagy jelszó.";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin bejelentkezés</title>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <h1 class="h4 mb-3 text-center">Admin bejelentkezés</h1>
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?> 
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Felhasználónév</label>
                        <input type="text" name="username" class="form-control"
                        value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jelszó</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Belépés</button>
                    <button class="btn btn-danger mt-3"><a href="../public/index.php" class="link-light link-offset-2 link-underline link-underline-opacity-0">Vissza</a></button>
                </form>  
            </div>
        </div>
    </div>
    
</body>
</html>