<?php
// #0 model/Database.php

class Database
{
    // #1 Istanza statica per implementare il pattern Singleton
    private static $instance = null;
    private $connection;

    /**
     * Costruttore privato per impedire l'istanziazione diretta dall'esterno.
     * Utilizzo DbConfig per caricare le credenziali dal file JSON.
     */
    private function __construct()
    {
        try {
            // #2 Carico le credenziali tramite il mio caricatore di configurazioni JSON
            $config = new DbConfig();

            // #3 Definizione del Data Source Name (DSN)
            $dsn = "mysql:host={$config->host};port={$config->port};dbname={$config->dbName};charset=utf8mb4";

            // #4 Opzioni di configurazione PDO per migliorare sicurezza e usabilità
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // #5 Lancio eccezioni in caso di errori SQL
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // #6 Restituisco i dati come array associativi
                PDO::ATTR_EMULATE_PREPARES   => false,                  // #7 Utilizzo i prepared statements reali per sicurezza come abbiamo visto in TPSIT
            ];

            $this->connection = new PDO($dsn, $config->username, $config->password, $options);
        } catch (PDOException $e) {
            // #5 Registro l'errore nel log di sistema senza esporre dati sensibili all'utente
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
            // #6 Se l'istanza non esiste, la creo richiamando il costruttore privato
            self::$instance = new Database();
        }
        // #7 Restituisco l'oggetto connessione PDO
        return self::$instance->connection;
    }
}
