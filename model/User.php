<?php
// model/User.php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function register($email, $password, $firstName, $lastName)
    {
        try {
            // 1. Hash the password (SECURITY FIRST!)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // 2. Insert into 'users'
            $sqlUser = "INSERT INTO users (email, password_hash) VALUES (:email, :password)";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute(['email' => $email, 'password' => $hashedPassword]);

            $userId = $this->db->lastInsertId();

            // 3. Insert into 'customers'
            $sqlCust = "INSERT INTO customers (id_customer) VALUES (:id)";
            $stmtCust = $this->db->prepare($sqlCust);
            $stmtCust->execute(['id' => $userId]);

            // 4. Insert into 'customer_profiles'
            $sqlProf = "INSERT INTO customer_profiles (id_customer, first_name, last_name) VALUES (:id, :f_name, :l_name)";
            $stmtProf = $this->db->prepare($sqlProf);
            $stmtProf->execute([
                'id' => $userId,
                'f_name' => $firstName,
                'l_name' => $lastName
            ]);

            return true;
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Recupera un utente tramite email per il login
     */
    public function getByEmail($email)
    {
        // Facciamo una LEFT JOIN con superadmins per capire il ruolo al volo
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
