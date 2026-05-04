<?php
// model/User.php
class User
{
    private $db;

    public function __construct()
    {
        // Ottengo l'istanza del database tramite il pattern Singleton
        $this->db = Database::getInstance();
    }

    public function register($email, $password, $firstName, $lastName)
    {
        try {
            // 1. Eseguo l'hashing della password (LA SICUREZZA PRIMA DI TUTTO!)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // 2. Inserisco i dati nella tabella 'users'
            $sqlUser = "INSERT INTO users (email, password_hash) VALUES (:email, :password)";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute(['email' => $email, 'password' => $hashedPassword]);

            $userId = $this->db->lastInsertId();

            // 3. Inserisco l'ID nella tabella 'customers'
            $sqlCust = "INSERT INTO customers (id_customer) VALUES (:id)";
            $stmtCust = $this->db->prepare($sqlCust);
            $stmtCust->execute(['id' => $userId]);

            // 4. Inserisco i dettagli anagrafici nella tabella 'customer_profiles'
            $sqlProf = "INSERT INTO customer_profiles (id_customer, first_name, last_name) VALUES (:id, :f_name, :l_name)";
            $stmtProf = $this->db->prepare($sqlProf);
            $stmtProf->execute([
                'id' => $userId,
                'f_name' => $firstName,
                'l_name' => $lastName
            ]);

            return true;
        } catch (Exception $e) {
            // Registro l'errore nel log di sistema se qualcosa va storto durante la registrazione
            error_log("Errore in fase di registrazione: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Recupero un utente tramite email per gestire il login
     */
    public function getByEmail($email)
    {
        // Eseguo una LEFT JOIN con la tabella superadmins per identificare il ruolo dell'utente
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

    /**
     * Recupera il profilo completo di un utente per l'Area Personale
     */
    public function getUserProfile($id)
    {
        $sql = "SELECT u.id_user, u.email, cp.first_name, cp.last_name, u.created_at
                FROM users u
                LEFT JOIN customer_profiles cp ON u.id_user = cp.id_customer
                WHERE u.id_user = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Eliminazione account (Persistence Layer)
     * In TPSIT, l'integrità referenziale è garantita dai vincoli FK nel DB.
     */
    public function deleteAccount($id)
    {
        try {
            $sql = "DELETE FROM users WHERE id_user = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (Exception $e) {
            error_log("Errore eliminazione account ID $id: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Recupera i dati di un utente specifico tramite il suo ID univoco 🔍
     * Implementazione dell'astrazione dei dati per il profilo.
     */
    public function getUserById($id)
    {
        // Recupero l'email (che funge da username nel sistema) 
        // e i dettagli dal profilo
        $sql = "SELECT u.id_user, u.email, cp.first_name, cp.last_name, u.created_at,
         cp.phone, ad.street, ad.postal_code, ad.city, ad.province, ad.country  
            FROM users u
            LEFT JOIN customer_profiles cp ON u.id_user = cp.id_customer
            LEFT JOIN addresses ad ON cp.id_profile = ad.id_profile
            WHERE u.id_user = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Metodo per l'eliminazione del record (richiesto dal Controller) 🗑️
     */
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id_user = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
