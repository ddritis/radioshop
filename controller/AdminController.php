<?php
// controller/AdminController.php
require_once 'BaseController.php';
require_once 'model/Product.php';

class AdminController extends BaseController
{
    /**
     * Pagina principale della dashboard Admin
     */
    public function dashboard()
    {
        $productModel = new Product();

        // Chiamo il metodo per avere tutti i prodotti da mostrare nella tabella
        $allProducts = $productModel->getAllActive();

        $viewData = [
            'pageTitle' => 'Pannello Amministratore',
            'products'  => $allProducts
        ];

        // Uso la vista dedicata
        $this->renderView('admin_dashboard', $viewData);
    }
}
