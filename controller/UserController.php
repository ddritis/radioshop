<?php
// controller/UserController.php
require_once 'BaseController.php';
require_once 'model/Order.php';

class UserController extends BaseController
{
    /**
     * Gestisco la visualizzazione dello storico ordini dell'utente
     */
    public function orders()
    {
        // Mi assicuro che l'accesso sia consentito solo agli utenti autenticati
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        // Istanzio il Model degli ordini per recuperare i dati dal database
        $orderModel = new Order();

        // Estraggo tutti gli ordini effettuati dall'utente attualmente in sessione
        $orders = $orderModel->getCustomerOrders($_SESSION['userId']);

        // Passo i dati alla view per mostrare la lista degli ordini e le relative fatture
        $this->renderView('my_orders', [
            'pageTitle' => 'I Miei Ordini',
            'orders'    => $orders
        ]);
    }
}
