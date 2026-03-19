<?php
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/config/database.php';

$sql = file_get_contents('update_db.sql');
$db = Database::getConnection();
$db->exec($sql);
echo "Database updated successfully.\n";
