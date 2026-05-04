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

    public function invoice()
    {
        // 🔐 Sicurezza applicativa: Accesso solo ad utenti autenticati
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $orderId = $_GET['id'] ?? null;
        $orderModel = new Order();

        // Recupero dati: Interazione con DB (Persistence Layer)
        // Passiamo anche l'ID utente per garantire che veda solo i propri ordini
        $order = $orderModel->getOrderDetails($orderId, $_SESSION['userId']);

        if (!$order) {
            // Gestione errori: se l'ordine non esiste o non appartiene all'utente
            header("Location: index.php?page=user&action=orders&error=not_found");
            exit();
        }

        // 2. RECUPERO PRODOTTI DELL'ORDINE 🛒
        $items = $orderModel->getOrderItems($orderId);

        // 🎨 Presentation Layer: Caricamento della View specifica
        $this->renderView('order_invoice', [
            'pageTitle' => 'Dettaglio Fattura #' . $order['invoice_number'],
            'order'     => $order,
            'items'     => $items // Passiamo i prodotti alla View
        ]);
    }
}
