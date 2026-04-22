<?php
// controller/CartController.php
require_once 'BaseController.php';
require_once 'model/Cart.php';

class CartController extends BaseController
{

    public function add()
    {
        // Protezione: solo gli utenti loggati possono aggiungere al carrello
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $productId = $_GET['id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if ($productId) {
            $cartModel = new Cart();
            $cartId = $cartModel->getOrCreateCart($_SESSION['userId']);
            $cartModel->addProduct($cartId, $productId, $quantity);
        }

        // Dopo l'aggiunta, mandiamo l'utente a vedere il carrello
        header("Location: index.php?page=cart&action=index");
        exit();
    }

    public function index()
    {
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $cartModel = new Cart();
        $items = $cartModel->getItems($_SESSION['userId']);

        // Calcoliamo il totale generale
        $total = 0;
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }

        $this->renderView('cart_view', [
            'pageTitle' => 'Il tuo Carrello',
            'items' => $items,
            'total' => $total
        ]);
    }
}
