<?php
// Entry point utama aplikasi
error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

// Muat berkas core MVC
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/BaseModel.php';
require_once APP_PATH . '/core/BaseController.php';
require_once APP_PATH . '/core/Router.php';

// Muat seluruh berkas model
require_once APP_PATH . '/models/ShelterModel.php';
require_once APP_PATH . '/models/VaccineModel.php';
require_once APP_PATH . '/models/AnimalModel.php';

// Jalankan sistem router aplikasi
$router = new Router();
$router->dispatch();
