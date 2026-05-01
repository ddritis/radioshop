<?php
// model/Product.php

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Recupera i prodotti attivi con il prezzo attuale
     */
    public function getAllActive()
    {
        // Query che prende il prezzo valido oggi (valid_to è NULL o futuro)
        $sql = "SELECT p.id_product, p.product_name, p.description, pl.price 
                FROM products p
                JOIN price_lists pl ON p.id_product = pl.id_product
                WHERE p.is_active = 1 
                AND (pl.valid_to IS NULL OR pl.valid_to >= CURDATE())
                AND pl.valid_from <= CURDATE()";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $sql = "SELECT p.*, pl.price, c.category_name 
            FROM products p
            JOIN price_lists pl ON p.id_product = pl.id_product
            JOIN categories c ON p.id_category = c.id_category
            WHERE p.id_product = :id 
            AND (pl.valid_to IS NULL OR pl.valid_to >= CURDATE())
            AND pl.valid_from <= CURDATE()";

        $stmt = $this->db->prepare($sql);
        // Uso il prepared statement per evitare SQL Injection
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
