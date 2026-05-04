<?php
// controller/CartController.php
require_once 'BaseController.php';
require_once 'model/Cart.php';

class CartController extends BaseController
{
    /**
     * Gestisco l'aggiunta di un prodotto al carrello
     */
    public function add()
    {
        // Controllo che l'utente sia loggato prima di permettere l'aggiunta
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        // Recupero l'ID del prodotto dall'URL e la quantità dal form
        $productId = $_GET['id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if ($productId) {
            $cartModel = new Cart();
            // Recupero o creo il carrello specifico per l'utente loggato
            $cartId = $cartModel->getOrCreateCart($_SESSION['userId']);
            // Aggiungo fisicamente il prodotto al carrello nel database
            $cartModel->addProduct($cartId, $productId, $quantity);
        }

        // Una volta completata l'operazione, reindirizzo l'utente alla visualizzazione del carrello
        header("Location: index.php?page=cart&action=index");
        exit();
    }

    /**
     * Visualizzo il contenuto del carrello
     */
    public function index()
    {
        // Mi assicuro che solo l'utente proprietario possa vedere il proprio carrello
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        $cartModel = new Cart();
        // Estraggo dal database tutti gli elementi nel carrello dell'utente
        $items = $cartModel->getItems($_SESSION['userId']);

        // Eseguo il calcolo del totale complessivo scorrendo gli elementi
        $total = 0;
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }

        // Passo i dati alla view per la generazione della pagina HTML
        $this->renderView('cart_view', [
            'pageTitle' => 'Il tuo Carrello',
            'items' => $items,
            'total' => $total
        ]);
    }

    public function clear()
    {
        // Verifica sicurezza: utente loggato?
        if (!isset($_SESSION['userId'])) {
            header("Location: index.php?page=auth&action=login");
            exit();
        }

        // Istanzio il modello per agire sul database
        $cartModel = new Cart();

        // Chiamo il metodo di cancellazione nel Model (lo creeremo tra un attimo)
        $cartModel->clearCart($_SESSION['userId']);

        // Reindirizzamento alla vista del carrello aggiornata
        header("Location: index.php?page=cart&action=index");
        exit();
    }
}
