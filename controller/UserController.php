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

    /**
     * Modifica il profilo utente (solo i dati modificabili)
     */
    public function editProfile()
    {
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $userModel = new User();
        $user = $userModel->getUserById($_SESSION['userId']);

        $this->renderView('user_edit_profile', [
            'pageTitle' => 'Modifica Profilo',
            'user' => $user
        ]);
    }

    public function updateProfile()
    {
        // Verifico che l'utente sia autenticato
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        // Verifico che la richiesta arrivi tramite POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=user&action=profile");
            exit();
        }

        $userId = $_SESSION['userId'];

        // Recupero e pulizia dati
        $data = [
            'phone'           => trim($_POST['phone'] ?? ''),
            'street'          => trim($_POST['street'] ?? ''),
            'building_number' => trim($_POST['building_number'] ?? ''),
            'postal_code'     => trim($_POST['postal_code'] ?? ''),
            'city'            => trim($_POST['city'] ?? ''),
            'province'        => trim($_POST['province'] ?? ''),
            'country'         => trim($_POST['country'] ?? '')
        ];

        // Validazione minima
        foreach ($data as $value) {
            if (empty($value)) {
                header("Location: index.php?page=user&action=editProfile&error=empty_fields");
                exit();
            }
        }

        $userModel = new User();

        // Salvataggio dati profilo
        $userModel->saveProfileData($userId, $data);

        // Redirect finale
        header("Location: index.php?page=user&action=profile&success=profile_updated");
        exit();
    }
}
