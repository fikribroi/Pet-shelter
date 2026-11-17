<?php
// Pengelola koneksi database singleton
class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    // Ambil instansi koneksi PDO
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $configPath = dirname(__DIR__, 2) . '/config/database.php';
            if (!file_exists($configPath)) {
                throw new RuntimeException("File konfigurasi database tidak ditemukan.");
            }

            $config = require $configPath;

            $dsn = sprintf(
                "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                $config['host'],
                $config['port'],
                $config['dbname'],
                $config['charset']
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            } catch (PDOException $e) {
                die("Koneksi Database Gagal: " . htmlspecialchars($e->getMessage()));
            }
        }

        return self::$instance;
    }
}
