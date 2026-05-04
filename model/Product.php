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

    /**
     * Inserisce un nuovo prodotto nel database 
     */
    public function insert($name, $price, $stock, $image, $id_cat, $description)
    {
        try {
            // Iniziamo una transazione per sicurezza applicativa
            $this->db->beginTransaction();

            // Passaggio 1: Inserimento anagrafica prodotto
            $sqlProd = "INSERT INTO products (product_name, id_category, stock_quantity, image_path, is_active, description) 
                    VALUES (:name, :id_cat, :stock, :image, 1, :description)";
            $stmtProd = $this->db->prepare($sqlProd);
            $stmtProd->execute([
                'name'   => $name,
                'id_cat' => $id_cat,
                'stock'  => $stock,
                'image'  => $image,
                'description' => $description
            ]);

            $newProductId = $this->db->lastInsertId(); // Recuperiamo l'ID generato

            // Passaggio 2: Inserimento prezzo nella tabella dedicata
            $sqlPrice = "INSERT INTO price_lists (id_product, price, valid_from) 
                     VALUES (:id_p, :price, CURDATE())";
            $stmtPrice = $this->db->prepare($sqlPrice);
            $stmtPrice->execute([
                'id_p'  => $newProductId,
                'price' => $price
            ]);

            $this->db->commit(); // Faccio il commit al DB
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack(); // Se qualcosa fallisce, annullo tutto
            error_log("Errore Transazione: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminazione Logica di un prodotto (Soft Delete) 🗑️
     */
    public function delete($id)
    {
        try {
            // Non eliminiamo la riga, cambiamo solo lo stato
            $sql = "UPDATE products SET is_active = 0 WHERE id_product = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Errore eliminazione logica: " . $e->getMessage());
            return false;
        }
    }
}
