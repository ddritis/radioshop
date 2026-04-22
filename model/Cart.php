<?php
// model/Cart.php

class Cart
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Recupera o crea un carrello per l'utente
     */
    public function getOrCreateCart($customerId)
    {
        // Cerchiamo se esiste già un carrello
        $sql = "SELECT id_cart FROM carts WHERE id_customer = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $customerId]);
        $cart = $stmt->fetch();

        if ($cart) {
            return $cart['id_cart'];
        }

        // Se non esiste, lo creiamo
        $sqlInsert = "INSERT INTO carts (id_customer) VALUES (:id)";
        $this->db->prepare($sqlInsert)->execute(['id' => $customerId]);
        return $this->db->lastInsertId();
    }

    /**
     * Recupera tutti i prodotti nel carrello di un utente
     */
    public function getItems($userId)
    {
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
        return $stmt->fetchAll();
    }

    /**
     * Aggiunge un prodotto al carrello o ne incrementa la quantità
     */
    public function addProduct($cartId, $productId, $quantity)
    {
        // Usiamo tre segnaposti distinti per non confondere PDO
        $sql = "INSERT INTO cart_items (id_cart, id_product, quantity) 
            VALUES (:cart, :prod, :qty_insert)
            ON DUPLICATE KEY UPDATE quantity = quantity + :qty_update";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'cart'       => $cartId,
            'prod'       => $productId,
            'qty_insert' => $quantity,
            'qty_update' => $quantity
        ]);
    }
}
