<?php
    declare(strict_types=1);

    /**
     * @param PDO $pdo
     * @return array
     */
    
    function get_active_services(PDO $pdo): array
    {
        $sql = "SELECT id, title, description, sort_order, is_active, created_at
                FROM services
                WHERE is_active = 1
                ORDER BY sort_order ASC, created_at DESC";

        $stmt = $pdo -> query($sql);
        return $stmt -> fetchAll();
    }

    function get_active_portfolio(PDO $pdo): array
    {
        $sql = "SELECT id, title, short_description, sort_order, is_activate, created_at
                FROM portfolio
                WHERE is_activate = 1
                ORDER BY sort_order ASC, created_at DESC";

        $stmt = $pdo ->query($sql);
        return $stmt->fetchAll();
    }

    function get_homepage_content(PDO $pdo): array
    {
        $stmt = $pdo -> query("SELECT key_name, value FROM settings");
        $rows = $stmt->fetchAll();

        $data = [];
        foreach($rows as $row) {
            $data[$row['key_name']] = $row['value'];
        }
        return $data;
    }
?>