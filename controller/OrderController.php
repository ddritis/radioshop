<?php
// controller/OrderController.php
require_once 'BaseController.php';
require_once 'model/Cart.php';
require_once 'model/Order.php';

class OrderController extends BaseController
{
    /**
     * Gestisco la procedura di checkout dell'ordine
     */
    public function checkout()
    {
        // Verifico che l'utente sia loggato prima di procedere
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $userId = $_SESSION['userId'];
        $cartModel = new Cart();
        $orderModel = new Order();

        // Recupero gli elementi attualmente presenti nel carrello per il calcolo finale
        $items = $cartModel->getItems($userId);

        // Se il carrello è vuoto, reindirizzo l'utente alla home
        if (empty($items)) {
            header("Location: index.php?page=home");
            exit();
        }

        // Calcolo il totale dell'ordine sommando i subtotali degli elementi
        $total = 0;
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }

        // Registro l'ordine nel database tramite il Model
        $orderId = $orderModel->createOrder($userId, $total, $items);

        if ($orderId) {
            // Se l'ordine è creato con successo, mostro la pagina di conferma
            $this->renderView('order_success', [
                'pageTitle' => 'Ordine Completato',
                'orderId'   => $orderId
            ]);
        }
    }
}
