<?php
// Abstract class dasar controller
abstract class BaseController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }
    }

    // Render tampilan view layout
    protected function render(string $viewPath, array $data = []): void
    {
        extract($data);
        $flash = $this->getFlash();
        $csrfToken = $this->generateCsrfToken();

        $baseViewDir = dirname(__DIR__) . '/views/';
        $viewFile = $baseViewDir . $viewPath . '.php';

        if (!file_exists($viewFile)) {
            die("File View tidak ditemukan.");
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        $layoutFile = $baseViewDir . 'layouts/main.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    // Redirect ke URL tujuan
    protected function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }

    // Cek metode request POST
    protected function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }

    // Ambil data input POST
    protected function getPost(string $key, $default = null)
    {
        if (isset($_POST[$key])) {
            return is_string($_POST[$key]) ? trim($_POST[$key]) : $_POST[$key];
        }
        return $default;
    }

    // Ambil data parameter GET
    protected function getQuery(string $key, $default = null)
    {
        if (isset($_GET[$key])) {
            return is_string($_GET[$key]) ? trim($_GET[$key]) : $_GET[$key];
        }
        return $default;
    }

    // Set pesan flash notifikasi
    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['_flash'] = [
            'type'    => $type,
            'message' => $message
        ];
    }

    // Ambil pesan flash session
    protected function getFlash(): ?array
    {
        if (isset($_SESSION['_flash'])) {
            $flash = $_SESSION['_flash'];
            unset($_SESSION['_flash']);
            return $flash;
        }
        return null;
    }

    // Buat token keamanan CSRF
    protected function generateCsrfToken(): string
    {
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    // Validasi token keamanan CSRF
    protected function validateCsrfToken(?string $token): bool
    {
        if (empty($token) || empty($_SESSION['_csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['_csrf_token'], $token);
    }
}
