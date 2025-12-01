<?php
    declare(strict_types=1);

    function find_admin_by_username(PDO $pdo, string $username): ?array
    {
        $stmt = $pdo -> prepare(
            'SELECT * FROM admin_users WHERE username = :username LIMIT 1'
        );
        $stmt ->execute(['username' => $username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    function is_admin_logged_in(): bool
    {
        return !empty($_SESSION['admin_id']);
    }

    function admin_login(): void
    {
        if (!is_admin_logged_in()){
            header('Location: index.php');
            exit;
        }
    }
?>