<?php
// controller/HomeController.php
require_once 'BaseController.php';

class HomeController extends BaseController
{

    public function index()
    {
        // 1. Data simulation (later we will use the Model)
        $viewData = [
            'pageTitle' => 'Welcome to our E-commerce',
            'products' => [
                ['id' => 1, 'name' => 'Laptop', 'price' => 999.99],
                ['id' => 2, 'name' => 'Smartphone', 'price' => 499.99]
            ]
        ];

        // 2. Render the view using the base method
        // This will load view/home_page.php
        $this->renderView('home', $viewData);
    }
}
