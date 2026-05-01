<?php
// controller/ProductController.php
require_once 'BaseController.php';
require_once 'model/Product.php';

class ProductController extends BaseController
{
    /**
     * Gestisco la visualizzazione del dettaglio di un singolo prodotto
     */
    public function show()
    {
        // Recupero l'ID del prodotto direttamente dall'URL tramite il parametro GET
        $id = $_GET['id'] ?? null;

        // Se l'ID non è presente, reindirizzo l'utente alla home page
        if (!$id) {
            header("Location: index.php?page=home");
            exit();
        }

        // Istanzio il Model Product per interrogare il database
        $productModel = new Product();
        // Cerco il prodotto specifico nel DB utilizzando l'ID recuperato
        $product = $productModel->getById($id);

        // Se il prodotto non esiste nel database, interrompo l'esecuzione con un messaggio
        if (!$product) {
            die("Prodotto non trovato.");
        }

        // Preparo i dati necessari per la pagina di dettaglio
        $viewData = [
            'pageTitle' => $product['product_name'],
            'product'   => $product
        ];

        // Richiamo il metodo per renderizzare la view specifica passandole i dati del prodotto
        $this->renderView('product_detail', $viewData);
    }
}
