<?php
// controller/HomeController.php
require_once 'BaseController.php';
require_once 'model/Product.php'; // Importo il Model per interagire con i dati dei prodotti

class HomeController extends BaseController
{
    /**
     * Gestisco la visualizzazione della pagina principale dello store
     */
    public function index()
    {
        // Istanzio il Model per accedere alle funzioni del database
        $productModel = new Product();

        // Recupero la lista dei prodotti attivi direttamente dal DB
        $activeProducts = $productModel->getAllActive();

        // Preparo l'array dei dati da iniettare nella View
        $viewData = [
            'pageTitle' => 'Il nostro Catalogo Tech',
            'products'  => $activeProducts
        ];

        // Richiamo il metodo della classe base per caricare view/home.php
        $this->renderView('home', $viewData);
    }
}
