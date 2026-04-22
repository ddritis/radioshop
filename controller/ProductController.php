<?php
// controller/ProductController.php
require_once 'BaseController.php';
require_once 'model/Product.php';

class ProductController extends BaseController
{

    public function show()
    {
        // Recuperiamo l'ID dall'URL
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: index.php?page=home");
            exit();
        }

        $productModel = new Product();
        $product = $productModel->getById($id);

        if (!$product) {
            die("Product not found.");
        }

        $viewData = [
            'pageTitle' => $product['product_name'],
            'product'   => $product
        ];

        $this->renderView('product_detail', $viewData);
    }
}
