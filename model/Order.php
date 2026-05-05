<?php
// model/Order.php

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Crea l'ordine partendo dai dati del carrello
     */
    public function createOrder($userId, $totalAmount, $items)
    {
        // 1. Inserimento dell'ordine (rimosso total_amount perché non esiste nella tabella orders)
        $sqlOrder = "INSERT INTO orders (id_customer, status) VALUES (:uid, 'paid')";
        $stmtOrder = $this->db->prepare($sqlOrder);
        $stmtOrder->execute([
            'uid'   => $userId
        ]);

        $orderId = $this->db->lastInsertId();

        // 2. Spostamento prodotti nel dettaglio ordine
        foreach ($items as $item) {
            $sqlItem = "INSERT INTO order_items (id_order, id_product, quantity, unit_price) 
                    VALUES (:oid, :pid, :qty, :price)";
            $this->db->prepare($sqlItem)->execute([
                'oid'   => $orderId,
                'pid'   => $item['id_product'],
                'qty'   => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // 3. Generazione fattura (Qui total_amount esiste nello schema!)
        $invoiceNum = "INV-" . date("Ymd") . "-" . $orderId;
        $sqlInv = "INSERT INTO invoices (id_order, invoice_number, total_amount) 
               VALUES (:oid, :num, :total)";
        $this->db->prepare($sqlInv)->execute([
            'oid'   => $orderId,
            'num'   => $invoiceNum,
            'total' => $totalAmount
        ]);

        // 4. Svuotamento del carrello
        $sqlClear = "DELETE ci FROM cart_items ci 
                 JOIN carts c ON ci.id_cart = c.id_cart 
                 WHERE c.id_customer = :uid";
        $this->db->prepare($sqlClear)->execute(['uid' => $userId]);

        return $orderId;
    }

    /**
     * Recupera lo storico ordini di un cliente con i dati della fattura
     */
    public function getCustomerOrders($userId)
    {
        $sql = "SELECT o.id_order, o.order_date, o.status, i.invoice_number, i.total_amount
            FROM orders o
            LEFT JOIN invoices i ON o.id_order = i.id_order
            WHERE o.id_customer = :uid
            ORDER BY o.order_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    public function getOrderDetails($orderId, $userId)
    {
        $sql = "SELECT o.*, i.invoice_number, i.total_amount, cp.first_name, cp.last_name, u.email
            FROM orders o
            LEFT JOIN invoices i ON o.id_order = i.id_order
            LEFT JOIN customer_profiles cp ON o.id_customer = cp.id_customer
            LEFT JOIN users u ON o.id_customer = u.id_user
            WHERE o.id_order = :orderId AND o.id_customer = :userId";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['orderId' => $orderId, 'userId' => $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Recupera i prodotti inclusi in un ordine specifico 📦
     */
    public function getOrderItems($orderId)
    {
        $sql = "SELECT oi.*, p.product_name AS name 
            FROM order_items oi
            JOIN products p ON oi.id_product = p.id_product
            WHERE oi.id_order = :oid";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['oid' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Recuperiamo tutte le righe
    }
}
