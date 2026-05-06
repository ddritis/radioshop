<?php
// #0 controller/HomeController.php
require_once 'BaseController.php';
require_once 'model/Product.php'; // #1 Importo il Model per interagire con i dati dei prodotti

class HomeController extends BaseController
{
    /**
     * Gestisco la visualizzazione della pagina principale dello store
     */
    public function index()
    {
        // #2 Istanzio il Model per accedere alle funzioni del database
        $productModel = new Product();

        // #3 Recupero la lista dei prodotti attivi direttamente dal DB
        $activeProducts = $productModel->getAllActive();

        // #4 Preparo l'array dei dati da iniettare nella View
        $viewData = [
            'pageTitle' => 'Il nostro Catalogo Tech',
            'products'  => $activeProducts
        ];

        // #5 Richiamo il metodo della classe base per caricare view/home.php
        $this->renderView('home', $viewData);
    }
}
