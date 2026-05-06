<?php
// controller/UserController.php
require_once 'BaseController.php';
require_once 'model/User.php';
require_once 'model/Order.php';

class UserController extends BaseController
{
    /**
     * Mostra la dashboard dell'area personale
     */
    public function profile()
    {
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $userModel = new User();
        $userData = $userModel->getUserById($_SESSION['userId']);

        $this->renderView('user_profile', [
            'pageTitle' => 'Area Personale',
            'user'      => $userData
        ]);
    }

    /**
     * Gestisce lo storico ordini
     */
    public function orders()
    {
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

    /**
     * Eliminazione account e distruzione sessione
     */
    public function deleteAccount()
    {
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $userModel = new User();

        // In TPSIT, l'eliminazione è un'operazione critica sui dati
        if ($userModel->deleteUser($_SESSION['userId'])) {
            // Logout forzato dopo la cancellazione
            session_destroy();
            header("Location: index.php?page=home&msg=account_deleted");
        } else {
            header("Location: index.php?page=user&action=profile&error=delete_failed");
        }
        exit();
    }
}
