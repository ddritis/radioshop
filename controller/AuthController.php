<?php
// controller/AuthController.php
require_once 'BaseController.php';
require_once 'model/User.php';

class AuthController extends BaseController
{
    /**
     * Gestisce il login degli utenti
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->getByEmail($email);

            // Verifico se l'utente esiste e se la password corrisponde all'hash nel DB
            if ($user && password_verify($password, $user['password_hash'])) {

                // Salviamo i dati essenziali in sessione
                $_SESSION['userId'] = $user['id_user'];
                $_SESSION['userEmail'] = $user['email'];
                // Uso ucfirst per assicurarci che l'iniziale sia maiuscola
                $_SESSION['userName'] = ucfirst($user['first_name'] ?? 'Utente');
                $_SESSION['isAdmin'] = ($user['role'] === 'admin');

                // Reindirizzo alla home (o alla dashboard se admin)
                header("Location: index.php?page=home");
                exit();
            } else {
                $error = "Credenziali non valide.";
            }
        }

        $this->renderView('login', ['pageTitle' => 'Login', 'error' => $error ?? null]);
    }

    /**
     * Gestisce la registrazione di nuovi clienti
     */
    public function register()
    {
        $error = null;

        // Se la richiesta è POST, l'utente sta inviando i dati del form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recupero i dati (In TPSIT: Fase di recupero parametri HTTP)
            $email     = $_POST['email'] ?? '';
            $password  = $_POST['password'] ?? '';
            $firstName = $_POST['first_name'] ?? '';
            $lastName  = $_POST['last_name'] ?? '';

            $userModel = new User();

            // Validazione e persistenza nel Model
            if ($userModel->register($email, $password, $firstName, $lastName)) {
                // Successo: redirect al login
                header("Location: index.php?page=auth&action=login&msg=success");
                exit();
            } else {
                $error = "Registrazione fallita. L'email potrebbe essere già presente.";
            }
        }

        // Visualizzazione del form (Sia al primo caricamento GET che in caso di errore)
        $this->renderView('register', [
            'pageTitle' => 'Crea Account',
            'error' => $error
        ]);
    }

    /**
     * Effettua il logout distruggendo la sessione
     */
    public function logout()
    {
        // Svuoto l'array di sessione
        $_SESSION = [];

        // Distruggo la sessione sul server
        session_destroy();

        // Cancello il cookie di sessione se presente
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Torno alla home
        header("Location: index.php?page=home");
        exit();
    }

    /**
     * Azione di default se non viene specificata una action
     */
    public function index()
    {
        $this->login();
    }
}
