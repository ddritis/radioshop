<?php
// controller/BaseController.php

abstract class BaseController
{
    /**
     * Helper method to render a view and pass data to it.
     * @param string $viewName The name of the file in the view folder (snake_case).
     * @param array $data Associative array of data to be extracted into variables.
     */
    protected function renderView($viewName, $data = [])
    {
        $viewPath = "view/{$viewName}.php";

        if (file_exists($viewPath)) {
            // Extract array keys as variables for the view (e.g., ['products' => $list] becomes $products)
            extract($data);

            // Start output buffering
            require_once $viewPath;
        } else {
            die("View file not found: $viewPath");
        }
    }
}
