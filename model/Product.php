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
        // AGGIUNTO: p.image_path nella SELECT
        $sql = "SELECT p.id_product, p.product_name, p.description, p.image_path, pl.price, c.category_name 
            FROM products p
            JOIN price_lists pl ON p.id_product = pl.id_product
            JOIN categories c ON p.id_category = c.id_category
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

    /**
     * Recupera i prodotti filtrati per famiglia (es. raspberry, orange)
     * @param string $family Il nome della famiglia da filtrare
     */
    public function getByFamily($family)
    {
        // Utilizziamo i Prepared Statements (:family) per la protezione SQL Injection
        $sql = "SELECT p.id_product, p.product_name, p.description, p.image_path, pl.price, c.category_name 
                FROM products p
                JOIN price_lists pl ON p.id_product = pl.id_product
                JOIN categories c ON p.id_category = c.id_category
                WHERE p.is_active = 1 
                AND c.category_name = :family
                AND (pl.valid_to IS NULL OR pl.valid_to >= CURDATE())
                AND pl.valid_from <= CURDATE()";

        $stmt = $this->db->prepare($sql);

        // Esecuzione sicura del comando SQL
        $stmt->execute(['family' => $family]);

        return $stmt->fetchAll();
    }
}
