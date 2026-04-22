<?php
// controller/HomeController.php
require_once 'BaseController.php';
require_once 'model/Product.php'; // Importiamo il Model

class HomeController extends BaseController
{

    public function index()
    {
        $productModel = new Product();

        // Prendiamo i dati reali dal DB
        $activeProducts = $productModel->getAllActive();

        $viewData = [
            'pageTitle' => 'Our Tech Catalog',
            'products'  => $activeProducts
        ];

        // Carica view/home.php
        $this->renderView('home', $viewData);
    }
}
