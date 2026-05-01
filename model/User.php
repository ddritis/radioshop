<?php
// model/User.php
class User
{
    private $db;

    public function __construct()
    {
        // Ottengo l'istanza del database tramite il pattern Singleton[cite: 1]
        $this->db = Database::getInstance();
    }

    public function register($email, $password, $firstName, $lastName)
    {
        try {
            // 1. Eseguo l'hashing della password (LA SICUREZZA PRIMA DI TUTTO!)[cite: 1]
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // 2. Inserisco i dati nella tabella 'users'[cite: 1]
            $sqlUser = "INSERT INTO users (email, password_hash) VALUES (:email, :password)";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute(['email' => $email, 'password' => $hashedPassword]);

            $userId = $this->db->lastInsertId();

            // 3. Inserisco l'ID nella tabella 'customers'[cite: 1]
            $sqlCust = "INSERT INTO customers (id_customer) VALUES (:id)";
            $stmtCust = $this->db->prepare($sqlCust);
            $stmtCust->execute(['id' => $userId]);

            // 4. Inserisco i dettagli anagrafici nella tabella 'customer_profiles'[cite: 1]
            $sqlProf = "INSERT INTO customer_profiles (id_customer, first_name, last_name) VALUES (:id, :f_name, :l_name)";
            $stmtProf = $this->db->prepare($sqlProf);
            $stmtProf->execute([
                'id' => $userId,
                'f_name' => $firstName,
                'l_name' => $lastName
            ]);

            return true;
        } catch (Exception $e) {
            // Registro l'errore nel log di sistema se qualcosa va storto durante la registrazione[cite: 1]
            error_log("Errore in fase di registrazione: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Recupero un utente tramite email per gestire il login
     */
    public function getByEmail($email)
    {
        // Eseguo una LEFT JOIN con la tabella superadmins per identificare il ruolo dell'utente[cite: 1]
        $sql = "SELECT u.*, cp.first_name,
            CASE WHEN s.id_superadmin IS NOT NULL THEN 'admin' ELSE 'customer' END as role
            FROM users u
            LEFT JOIN customer_profiles cp ON u.id_user = cp.id_customer
            LEFT JOIN superadmins s ON u.id_user = s.id_superadmin
            WHERE u.email = :email";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}
