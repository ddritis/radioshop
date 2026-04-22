<?php
// controller/UserController.php
require_once 'BaseController.php';
require_once 'model/Order.php';

class UserController extends BaseController
{

    public function orders()
    {
        // Protezione: solo utenti loggati
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $orderModel = new Order();
        $orders = $orderModel->getCustomerOrders($_SESSION['userId']);

        $this->renderView('my_orders', [
            'pageTitle' => 'I Miei Ordini',
            'orders'    => $orders
        ]);
    }
}
