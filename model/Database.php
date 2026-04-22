<?php
// model/Database.php

class Database
{
    // Static instance for Singleton pattern
    private static $instance = null;
    private $connection;

    /**
     * Private constructor to prevent direct instantiation.
     * It uses DbConfig to load JSON credentials.
     */
    private function __construct()
    {
        try {
            // Load credentials from our JSON config loader
            $config = new DbConfig();

            // Data Source Name
            $dsn = "mysql:host={$config->host};dbname={$config->dbName};charset=utf8mb4";

            // PDO configuration options for security and usability
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throws exceptions on SQL errors
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Returns associative arrays
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Uses real prepared statements
            ];

            $this->connection = new PDO($dsn, $config->username, $config->password, $options);
        } catch (PDOException $e) {
            // We log the error and stop execution without exposing sensitive data
            error_log("Database Connection Error: " . $e->getMessage());
            die("Connection failed. Please check your configuration.");
        }
    }

    /**
     * Static method to get the single PDO connection instance.
     * @return PDO
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}
