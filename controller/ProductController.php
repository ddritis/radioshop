<?php
// controller/ProductController.php
require_once 'BaseController.php';
require_once 'model/Product.php';

class ProductController extends BaseController
{
    /**
     * Visualizzazione del dettaglio di un singolo prodotto
     */
    public function show()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: index.php?page=home");
            exit();
        }

        $productModel = new Product();
        $product = $productModel->getById($id);

        if (!$product) {
            // Miglioramento TPSIT: invece di die(), usiamo il fail-safe
            header("Location: index.php?page=maintenance&action=underConstruction");
            exit();
        }

        $this->renderView('product_detail', [
            'pageTitle' => $product['product_name'],
            'product'   => $product
        ]);
    }

    /**
     * Gestisco la visualizzazione dei prodotti per categoria (SBC Family)
     * Es: index.php?page=product&action=category&family=raspberry
     */
    public function category()
    {
        // Cambiato 'family' in 'type' per leggere correttamente l'URL della navbar
        $type = $_GET['type'] ?? null;

        if (!$type) {
            header("Location: index.php?page=home");
            exit();
        }

        $productModel = new Product();

        // Passiamo il parametro al Model per la query filtrata
        $products = $productModel->getByFamily($type);

        // Gestione errori: se non ci sono prodotti, fail-safe verso manutenzione
        if (!$products) {
            header("Location: index.php?page=maintenance&action=underConstruction");
            exit();
        }

        // Titolo dinamico basato sul tipo
        $displayTitle = "Famiglia " . ucfirst($type) . " Pi";

        $this->renderView('category_list', [
            'pageTitle'    => $displayTitle,
            'products'     => $products,
            'categoryName' => ucfirst($type)
        ]);
    }

    public function list()
    {
        $productModel = new Product();
        // Recuperiamo tutti i prodotti attivi senza filtri di categoria
        $products = $productModel->getAllActive();

        // Se il DB è vuoto, usiamo il nostro fail-safe
        if (!$products) {
            header("Location: index.php?page=maintenance&action=underConstruction");
            exit();
        }

        $this->renderView('category_list', [
            'pageTitle'    => "Catalogo Completo",
            'products'     => $products,
            'categoryName' => "Tutti i Prodotti"
        ]);
    }
}
