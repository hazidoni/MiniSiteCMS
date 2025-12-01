<?php

    declare(strict_types=1);

    /**
     * @return PDO
     */

    function get_pdo(): PDO
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

        try{
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e){
            die('Adatbázis kapcsolat hiba: '. htmlspecialchars($e -> getMessage()));
        }

        return $pdo;
    }
?>