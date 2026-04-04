<?php
// index.php
session_start();

// Autoloading simulation (for now we require them manually)
require_once 'controller/BaseController.php'; // Load the base class first
require_once 'model/DbConfig.php';
require_once 'model/Database.php';

// Get the page and action from URL, or set defaults
$page   = $_GET['page']   ?? 'home';
$action = $_GET['action'] ?? 'index';

// Convert 'product' to 'ProductController' (PascalCase)
$controllerName = ucfirst($page) . 'Controller';
$controllerFile = "controller/$controllerName.php";

// Check if the controller file exists
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Check if the class exists inside the file
    if (class_exists($controllerName)) {
        $controllerObject = new $controllerName();
        
        // Check if the requested method (action) exists in the class
        if (method_exists($controllerObject, $action)) {
            // Security Check for Admin: you can centralize it here!
            if (strpos($page, 'admin') !== false) {
                if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
                    header("Location: index.php?page=home");
                    exit();
                }
            }
            
            // Execute the action (e.g., $controller->index())
            $controllerObject->$action();
        } else {
            // Method not found: 404 behavior
            header("Location: index.php?page=home");
        }
    }
} else {
    // Controller file not found: 404 behavior
    header("Location: index.php?page=home");
}