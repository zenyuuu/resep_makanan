<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=resep_makanan', 'root', '');
    file_put_contents(__DIR__ . '/test_db_out.txt', "PDO_OK\n", FILE_APPEND);
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/test_db_out.txt', "ERR: " . $e->getMessage() . "\n", FILE_APPEND);
    file_put_contents(__DIR__ . '/test_db_out.txt', "Code: " . $e->getCode() . "\n", FILE_APPEND);
}
