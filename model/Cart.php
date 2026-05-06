<?php
// #0 model/Cart.php

class Cart
{
    private $db;

    public function __construct()
    {
        // #1 Ottengo l'istanza del database tramite il pattern Singleton https://it.wikipedia.org/wiki/Singleton_(informatica)
        $this->db = Database::getInstance();
    }

    /**
     * Recupero o creo un carrello per l'utente specifico
     */
    public function getOrCreateCart($customerId)
    {
        // #2 Cerco se esiste già un carrello attivo per questo cliente
        $sql = "SELECT id_cart FROM carts WHERE id_customer = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $customerId]);
        $cart = $stmt->fetch();

        if ($cart) {
            // #3 Se lo trovo, restituisco l'ID esistente
            return $cart['id_cart'];
        }

        // #4 Se non esiste, ne inserisco uno nuovo per l'utente
        $sqlInsert = "INSERT INTO carts (id_customer) VALUES (:id)";
        $this->db->prepare($sqlInsert)->execute(['id' => $customerId]);

        // #5 Restituisco l'ultimo ID generato dal database
        return $this->db->lastInsertId();
    }

    /**
     * Recupero tutti i prodotti presenti nel carrello di un utente tramite JOIN
     */
    public function getItems($userId)
    {
        // #6 Eseguo una query complessa unendo prodotti e listini prezzi validi
        $sql = "SELECT p.product_name, p.id_product, ci.quantity, pl.price, 
            (ci.quantity * pl.price) AS subtotal
            FROM cart_items ci
            JOIN carts c ON ci.id_cart = c.id_cart
            JOIN products p ON ci.id_product = p.id_product
            JOIN price_lists pl ON p.id_product = pl.id_product
            WHERE c.id_customer = :userId
            AND (pl.valid_to IS NULL OR pl.valid_to >= CURDATE())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        // #7 Restituisco l'elenco completo degli elementi trovati
        return $stmt->fetchAll();
    }

    /**
     * Aggiungo un prodotto al carrello o ne incremento la quantità se già presente
     */
    public function addProduct($cartId, $productId, $quantity)
    {
        // #8 Utilizzo segnaposti distinti per gestire correttamente l'inserimento e l'aggiornamento
        $sql = "INSERT INTO cart_items (id_cart, id_product, quantity) 
            VALUES (:cart, :prod, :qty_insert)
            ON DUPLICATE KEY UPDATE quantity = quantity + :qty_update";

        $stmt = $this->db->prepare($sql);

        // #9 Eseguo il comando passando i parametri sanitizzati tramite PDO
        return $stmt->execute([
            'cart'       => $cartId,
            'prod'       => $productId,
            'qty_insert' => $quantity,
            'qty_update' => $quantity
        ]);
    }

    public function clearCart($userId)
    {
        //#10 Recupero l'ID del carrello dell'utente
        $cartId = $this->getOrCreateCart($userId);

        // #11 Query SQL per eliminare tutti i prodotti associati a quel carrello
        // #12 nota per TPSIT: uso i Prepared Statements per la sicurezza applicativa
        $sql = "DELETE FROM cart_items WHERE id_cart = :id_cart";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id_cart' => $cartId]);
    }
}
