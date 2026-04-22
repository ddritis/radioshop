<?php
// controller/AdminController.php
require_once 'BaseController.php';
require_once 'model/Product.php';

class AdminController extends BaseController
{
    /**
     * Pagina principale della Dashboard Admin
     */
    public function dashboard()
    {
        $productModel = new Product();

        // Recuperiamo tutti i prodotti per mostrarli in una tabella gestionale
        $allProducts = $productModel->getAllActive();

        $viewData = [
            'pageTitle' => 'Pannello Amministratore',
            'products'  => $allProducts
        ];

        // Carichiamo la vista dedicata
        $this->renderView('admin_dashboard', $viewData);
    }
}
