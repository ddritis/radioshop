<?php
// index.php
session_start();

// 1. Load Core Components
require_once 'model/DbConfig.php';
require_once 'model/Database.php';
require_once 'controller/BaseController.php';

// 2. Routing Configuration
$page   = $_GET['page']   ?? 'home';
$action = $_GET['action'] ?? 'index';

// 3. Dynamic Controller Mapping
// Example: 'auth' -> 'AuthController'
$controllerName = ucfirst($page) . 'Controller';
$controllerFile = "controller/$controllerName.php";

if (isset($_GET['debug'])) {
    echo "File cercato: " . $controllerFile . "<br>";
    echo "Classe cercata: " . $controllerName . "<br>";
    echo "Metodo cercato: " . $action . "<br>";
}

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerName)) {
        $controllerObject = new $controllerName();

        if (method_exists($controllerObject, $action)) {

            // 4. Centralized Security Layer
            // If the page starts with 'admin', check privileges
            if (str_starts_with($page, 'admin')) {
                if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
                    header("Location: index.php?page=home");
                    exit();
                }
            }

            // 5. Dispatch the request
            $controllerObject->$action();
        } else {
            // Se l'azione non esiste, usiamo la pagina under-construction
            header("Location: index.php?page=maintenance&action=underConstruction");
            exit();
        }
    }
} else {
    // Se il file del controller non esiste (es. page=spedizioni)
    header("Location: index.php?page=maintenance&action=underConstruction");
    exit();
}
