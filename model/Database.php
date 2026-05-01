<?php
// model/Database.php

class Database
{
    // Istanza statica per implementare il pattern Singleton
    private static $instance = null;
    private $connection;

    /**
     * Costruttore privato per impedire l'istanziazione diretta dall'esterno.
     * Utilizzo DbConfig per caricare le credenziali dal file JSON.
     */
    private function __construct()
    {
        try {
            // Carico le credenziali tramite il mio caricatore di configurazioni JSON
            $config = new DbConfig();

            // Definizione del Data Source Name (DSN)
            $dsn = "mysql:host={$config->host};dbname={$config->dbName};charset=utf8mb4";

            // Opzioni di configurazione PDO per migliorare sicurezza e usabilità
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lancio eccezioni in caso di errori SQL
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Restituisco i dati come array associativi
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Utilizzo i prepared statements reali per sicurezza
            ];

            $this->connection = new PDO($dsn, $config->username, $config->password, $options);
        } catch (PDOException $e) {
            // Registro l'errore nel log di sistema senza esporre dati sensibili all'utente
            error_log("Database Connection Error: " . $e->getMessage());
            die("Connessione fallita. Verifico la configurazione.");
        }
    }

    /**
     * Metodo statico per ottenere l'unica istanza della connessione PDO.
     * @return PDO
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            // Se l'istanza non esiste, la creo richiamando il costruttore privato
            self::$instance = new Database();
        }
        // Restituisco l'oggetto connessione PDO
        return self::$instance->connection;
    }
}
