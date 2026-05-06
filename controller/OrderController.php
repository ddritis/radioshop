<?php
// #0 controller/OrderController.php
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
        // #1 Verifico che l'utente sia loggato prima di procedere
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $userId = $_SESSION['userId'];
        $cartModel = new Cart();
        $orderModel = new Order();

        // #2 Recupero gli elementi attualmente presenti nel carrello per il calcolo finale
        $items = $cartModel->getItems($userId);

        // #3 Se il carrello è vuoto, reindirizzo l'utente alla home
        if (empty($items)) {
            header("Location: index.php?page=home");
            exit();
        }

        // #4 Calcolo il totale dell'ordine sommando i subtotali degli elementi
        $total = 0;
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }

        try {
            // #5 Registro l'ordine nel database tramite il Model
            $orderId = $orderModel->createOrder($userId, $total, $items);
        } catch (Exception $e) {
            if ($e->getMessage() === "Missing customer profile data") {
                header("Location: index.php?page=user&action=profile&error=missing_profile_data");
                exit();
            }

            throw $e;
        }

        if ($orderId) {
            // #6 Se l'ordine è creato con successo, mostro la pagina di conferma
            $this->renderView('order_success', [
                'pageTitle' => 'Ordine Completato',
                'orderId'   => $orderId
            ]);
        }
    }

    public function invoice()
    {
        // #7 Accesso solo ad utenti autenticati
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $orderId = $_GET['id'] ?? null;
        $orderModel = new Order();

        // #8 Recupero dati dal DB
        // #9 Passo anche l'ID utente per garantire che veda solo i propri ordini
        $order = $orderModel->getOrderDetails($orderId, $_SESSION['userId']);

        if (!$order) {
            // #10 Gestione errori: se l'ordine non esiste o non appartiene all'utente
            header("Location: index.php?page=user&action=orders&error=not_found");
            exit();
        }

        // #11 Recupero i prodotti dell'ordine
        $items = $orderModel->getOrderItems($orderId);

        // #12 "Chiamo" la View specifica
        $this->renderView('order_invoice', [
            'pageTitle' => 'Dettaglio Fattura #' . $order['invoice_number'],
            'order'     => $order,
            'items'     => $items // #13 Passo i prodotti alla View
        ]);
    }
}
