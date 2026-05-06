<?php
// #0 model/DbConfig.php

class DbConfig
{
    public $host;
    public $username;
    public $password;
    public $dbName;

    /**
     * Costruttore che utilizzo per caricare la configurazione del database da un file JSON.
     * Implemento un blocco try-catch per gestire eventuali errori di lettura del file o di parsing dei dati.
     */
    public function __construct()
    {
        $path = 'config/database.json';

        try {
            // #1 Verifico se il file di configurazione esiste nel percorso stabilito.
            if (!file_exists($path)) {
                throw new Exception("File di configurazione non trovato in: " . $path);
            }

            $jsonContent = file_get_contents($path);
            $config = json_decode($jsonContent, true);

            // #2 Verifico se la decodifica JSON è fallita o se mancano le chiavi obbligatorie (host, database).
            if ($config === null || !isset($config['host'], $config['database'])) {
                throw new Exception("Formato JSON non valido o corrotto in: " . $path);
            }

            // #3 Assegno i valori estratti alle proprietà della classe per renderli disponibili.
            $this->host = $config['host'];
            $this->username = $config['username'];
            $this->password = $config['password'];
            $this->dbName = $config['database'];
        } catch (Exception $e) {
            // #4 In caso di errore critico, interrompo l'esecuzione mostrando un messaggio chiaro.
            die("Errore di configurazione del Database: " . $e->getMessage());
        }
    }
}