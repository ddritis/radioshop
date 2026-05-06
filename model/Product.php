<?php
// #0 model/Product.php

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
        // #1 ottengo i prodotti flaggati come attivi
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
        // #2 Uso il prepared statement per evitare SQL Injection
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Recupera i prodotti filtrati per famiglia (es. raspberry, orange)
     * @param string $family Il nome della famiglia da filtrare
     */
    public function getByFamily($family)
    {
        // #3 Utilizzo i Prepared Statements (ad esempio :family) per la protezione SQL Injection come visto in classe
        $sql = "SELECT p.id_product, p.product_name, p.description, p.image_path, pl.price, c.category_name 
                FROM products p
                JOIN price_lists pl ON p.id_product = pl.id_product
                JOIN categories c ON p.id_category = c.id_category
                WHERE p.is_active = 1 
                AND c.category_name = :family
                AND (pl.valid_to IS NULL OR pl.valid_to >= CURDATE())
                AND pl.valid_from <= CURDATE()";

        $stmt = $this->db->prepare($sql);

        // #4 Esecuzione sicura del comando SQL
        $stmt->execute(['family' => $family]);

        return $stmt->fetchAll();
    }

    /**
     * Inserisce un nuovo prodotto nel database 
     */
    public function insert($name, $price, $stock, $image, $id_cat, $description)
    {
        try {
            // #5 Inizio una transazione perché la query è "lunga", per sicurezza è meglio così (lo abbiamo visto in Informatica)
            $this->db->beginTransaction();

            // #6 primo step: inserimento anagrafica prodotto
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

            $newProductId = $this->db->lastInsertId(); // #7 Recupero l'ID generato
            
            // #8 secondo step: inserimento prezzo nella tabella dedicata
            $sqlPrice = "INSERT INTO price_lists (id_product, price, valid_from) 
                     VALUES (:id_p, :price, CURDATE())";
            $stmtPrice = $this->db->prepare($sqlPrice);
            $stmtPrice->execute([
                'id_p'  => $newProductId,
                'price' => $price
            ]);

            $this->db->commit(); // #9 Faccio il commit al DB
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack(); // #10 Se qualcosa fallisce, annullo tutto tramite un Rollback (lo abbiamo visto in Informatica)
            error_log("Errore Transazione: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminazione Logica di un prodotto (lo contrassegno come non attivo per evitare di "rompere" il database)
     */
    public function delete($id)
    {
        try {
            // #11 Non elimino la riga, cambio solo lo stato
            $sql = "UPDATE products SET is_active = 0 WHERE id_product = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Errore eliminazione logica: " . $e->getMessage());
            return false;
        }
    }
}
