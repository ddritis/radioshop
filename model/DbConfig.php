<?php

class DbConfig
{
    public $host;
    public $username;
    public $password;
    public $dbName;

    /**
     * Constructor that loads database configuration from a JSON file.
     * Uses try-catch to handle potential file or parsing errors.
     */
    public function __construct()
    {
        $path = 'config/database.json';

        try {
            // Check if the configuration file exists
            if (!file_exists($path)) {
                throw new Exception("Configuration file not found at: " . $path);
            }

            $jsonContent = file_get_contents($path);
            $config = json_decode($jsonContent, true);

            // Check if JSON decoding failed (null) or if required keys are missing
            if ($config === null || !isset($config['host'], $config['database'])) {
                throw new Exception("Invalid or corrupted JSON format in: " . $path);
            }

            // Assign values to properties
            $this->host = $config['host'];
            $this->username = $config['username'];
            $this->password = $config['password'];
            $this->dbName = $config['database'];
        } catch (Exception $e) {
            // In a real scenario, you might log this error to a file
            // For now, we stop execution with a clear message
            die("Database Configuration Error: " . $e->getMessage());
        }
    }
}
