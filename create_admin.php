<?php
    /*Only run this file once so you get an admin profile
    * name: admin
    * password: admin123
    */

    declare(strict_types=1);

    require __DIR__ . '/app/config.php';
    require __DIR__ . '/app/db.php';

    $pdo = get_pdo();

    $username = 'admin';
    $password = 'admin123';

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo -> prepare(
        "INSERT INTO admin_users (username, password_hash) VALUES (:u, :p)"
    );
    $stmt ->execute([
        'u' => $username,
        'p' => $passwordHash,
    ]);

    echo "Admin létrehozva: $username: $password";
?>
