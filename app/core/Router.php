<?php
// Pengelola routing permintaan HTTP
class Router
{
    private static array $routes = [
        'dashboard' => 'DashboardController',
        'animals'   => 'AnimalController',
        'shelters'  => 'ShelterController',
        'vaccines'  => 'VaccineController'
    ];

    // Proses request ke controller
    public function dispatch(): void
    {
        $page = isset($_GET['page']) && trim($_GET['page']) !== '' 
            ? strtolower(trim($_GET['page'])) 
            : 'dashboard';

        $action = isset($_GET['action']) && trim($_GET['action']) !== '' 
            ? trim($_GET['action']) 
            : 'index';

        if (!array_key_exists($page, self::$routes)) {
            http_response_code(404);
            $this->renderNotFound("Halaman tidak ditemukan.");
            return;
        }

        $controllerName = self::$routes[$page];
        $controllerFile = dirname(__DIR__) . '/controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            http_response_code(500);
            die("Controller tidak ditemukan.");
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            http_response_code(500);
            die("Class controller tidak ada.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            $this->renderNotFound("Aksi tidak ditemukan.");
            return;
        }

        $controller->$action();
    }

    // Helper pembuat link URL
    public static function url(string $page = 'dashboard', string $action = 'index', array $params = []): string
    {
        $query = ['page' => $page];
        if ($action !== 'index' || !empty($params)) {
            $query['action'] = $action;
        }
        if (!empty($params)) {
            $query = array_merge($query, $params);
        }

        return 'index.php?' . http_build_query($query);
    }

    // Tampilan halaman error 404
    private function renderNotFound(string $message): void
    {
        $homeUrl = self::url('dashboard');
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>404 - Tidak Ditemukan</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
        <body class="bg-[#F5F7F5] text-[#24332F] min-h-screen flex items-center justify-center p-6">
            <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-stone-200 p-8 text-center">
                <div class="w-16 h-16 bg-[#E6EFE8] text-[#183B36] rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
                    404
                </div>
                <h1 class="text-2xl font-bold mb-2">Halaman Tidak Ditemukan</h1>
                <p class="text-stone-500 text-sm mb-6">{$message}</p>
                <a href="{$homeUrl}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#183B36] text-white rounded-xl text-sm font-medium">
                    Kembali ke Dashboard
                </a>
            </div>
        </body>
        </html>
HTML;
    }
}
