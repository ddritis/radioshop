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

            // Verifichiamo se l'utente esiste e se la password corrisponde all'hash nel DB
            if ($user && password_verify($password, $user['password_hash'])) {

                // Salviamo i dati essenziali in sessione
                $_SESSION['userId'] = $user['id_user'];
                $_SESSION['userEmail'] = $user['email'];
                // Usiamo ucfirst per assicurarci che l'iniziale sia maiuscola
                $_SESSION['userName'] = ucfirst($user['first_name'] ?? 'Utente');
                $_SESSION['isAdmin'] = ($user['role'] === 'admin');

                // Reindirizziamo alla home (o alla dashboard se admin)
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recuperiamo i dati dal form POST
            $email     = $_POST['email'] ?? '';
            $password  = $_POST['password'] ?? '';
            $firstName = $_POST['first_name'] ?? '';
            $lastName  = $_POST['last_name'] ?? '';

            $userModel = new User();

            // Tentiamo la registrazione (scrive su 3 tabelle: users, customers, customer_profiles)
            if ($userModel->register($email, $password, $firstName, $lastName)) {
                // Se va a buon fine, mandiamo l'utente al login
                header("Location: index.php?page=auth&action=login");
                exit();
            } else {
                $error = "Registrazione fallita. L'email potrebbe essere già presente.";
            }
        }

        // Carichiamo la view view/register.php
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
        // Svuotiamo l'array di sessione
        $_SESSION = [];

        // Distruggiamo la sessione sul server
        session_destroy();

        // Cancelliamo il cookie di sessione se presente (opzionale ma professionale)
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

        // Torniamo alla home
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
