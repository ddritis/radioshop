<?php
// controller/OrderController.php
require_once 'BaseController.php';
require_once 'model/Cart.php';
require_once 'model/Order.php';

class OrderController extends BaseController
{

    public function checkout()
    {
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $userId = $_SESSION['userId'];
        $cartModel = new Cart();
        $orderModel = new Order();

        // Recuperiamo i dati attuali del carrello per il calcolo finale
        $items = $cartModel->getItems($userId);

        if (empty($items)) {
            header("Location: index.php?page=home");
            exit();
        }

        $total = 0;
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }

        // Creiamo l'ordine nel DB
        $orderId = $orderModel->createOrder($userId, $total, $items);

        if ($orderId) {
            // Mandiamo alla pagina di successo
            $this->renderView('order_success', [
                'pageTitle' => 'Ordine Completato',
                'orderId'   => $orderId
            ]);
        }
    }
}
