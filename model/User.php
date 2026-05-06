<?php
// #0 model/User.php
class User
{
    private $db;

    public function __construct()
    {
        // #1 Ottengo l'istanza del database tramite il pattern Singleton
        $this->db = Database::getInstance();
    }

    /**
     * Registra un nuovo account cliente all'interno dell'applicazione (non valida per Amministratore).
     *
     * Il metodo esegue l'intero workflow di registrazione:
     * - genera l'hash sicuro della password tramite password_hash()
     * - crea il record di autenticazione nella tabella users
     * - crea il record associato nella tabella customers
     * - crea il profilo cliente con i dati anagrafici
     *
     * @param string $email      Indirizzo email dell'utente
     * @param string $password   Password in chiaro inserita durante la registrazione
     * @param string $firstName  Nome del cliente
     * @param string $lastName   Cognome del cliente
     *
     * @return bool Restituisce true in caso di successo, false in caso di errore
     */
    public function register($email, $password, $firstName, $lastName)
    {
        try {
            // #2 Eseguo l'hashing della password come abbiamo visto in TPSIT
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // #3 Inserisco i dati nella tabella 'users'
            $sqlUser = "INSERT INTO users (email, password_hash) VALUES (:email, :password)";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute(['email' => $email, 'password' => $hashedPassword]);

            $userId = $this->db->lastInsertId();

            // #4 Inserisco l'ID nella tabella 'customers'
            $sqlCust = "INSERT INTO customers (id_customer) VALUES (:id)";
            $stmtCust = $this->db->prepare($sqlCust);
            $stmtCust->execute(['id' => $userId]);

            // #5 Inserisco i dettagli anagrafici nella tabella 'customer_profiles'
            $sqlProf = "INSERT INTO customer_profiles (id_customer, first_name, last_name) VALUES (:id, :f_name, :l_name)";
            $stmtProf = $this->db->prepare($sqlProf);
            $stmtProf->execute([
                'id' => $userId,
                'f_name' => $firstName,
                'l_name' => $lastName
            ]);

            return true;
        } catch (Exception $e) {
            // #6 Registro l'errore nel log di sistema se qualcosa va storto durante la registrazione
            error_log("Errore in fase di registrazione: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Recupero un utente tramite email per gestire il login
     */
    public function getByEmail($email)
    {
        // #7 Eseguo una LEFT JOIN con la tabella superadmins per identificare il ruolo dell'utente
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
     * Recupera i dati di un utente specifico tramite il suo ID univoco
     * Implementazione dell'astrazione dei dati per il profilo.
     */
    public function getUserById($id)
    {
        // #8 Recupero l'email (che funge da username nel sistema) e i dettagli dal profilo
        $sql = "SELECT u.id_user, u.email, cp.first_name, cp.last_name, u.created_at,
         cp.phone, ad.street, ad.postal_code, ad.city, ad.province, ad.country, ad.building_number
            FROM users u
            LEFT JOIN customer_profiles cp ON u.id_user = cp.id_customer
            LEFT JOIN addresses ad ON cp.id_profile = ad.id_profile
            WHERE u.id_user = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Metodo per l'eliminazione del record (richiesto dal Controller)
     */
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id_user = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function saveProfileData($userId, $data)
    {
        try {
            $this->db->beginTransaction();

            // #9 Recupero il profilo cliente
            $sqlProfile = "SELECT id_profile 
                       FROM customer_profiles 
                       WHERE id_customer = :user_id";

            $stmtProfile = $this->db->prepare($sqlProfile);
            $stmtProfile->execute(['user_id' => $userId]);
            $profile = $stmtProfile->fetch(PDO::FETCH_ASSOC);

            if (!$profile) {
                throw new Exception("Customer profile not found");
            }

            $profileId = $profile['id_profile'];

            // #10 Aggiorno il numero di telefono
            $sqlUpdateProfile = "UPDATE customer_profiles
                             SET phone = :phone
                             WHERE id_profile = :profile_id";

            $stmtUpdateProfile = $this->db->prepare($sqlUpdateProfile);
            $stmtUpdateProfile->execute([
                'phone'      => $data['phone'],
                'profile_id' => $profileId
            ]);

            // #11 Verifico se esiste già un indirizzo per il profilo
            $sqlAddress = "SELECT id_address
                       FROM addresses
                       WHERE id_profile = :profile_id";

            $stmtAddress = $this->db->prepare($sqlAddress);
            $stmtAddress->execute(['profile_id' => $profileId]);
            $address = $stmtAddress->fetch(PDO::FETCH_ASSOC);

            if ($address) {
                // #12 Aggiorno indirizzo esistente
                $sqlUpdateAddress = "UPDATE addresses
                                 SET street = :street,
                                     building_number = :building_number,
                                     postal_code = :postal_code,
                                     city = :city,
                                     province = :province,
                                     country = :country
                                 WHERE id_address = :address_id";

                $stmtUpdateAddress = $this->db->prepare($sqlUpdateAddress);
                $stmtUpdateAddress->execute([
                    'street'          => $data['street'],
                    'building_number' => $data['building_number'],
                    'postal_code'     => $data['postal_code'],
                    'city'            => $data['city'],
                    'province'        => $data['province'],
                    'country'         => $data['country'],
                    'address_id'      => $address['id_address']
                ]);
            } else {
                // #13 Inserisco nuovo indirizzo
                $sqlInsertAddress = "INSERT INTO addresses 
                                 (id_profile, street, building_number, postal_code, city, province, country)
                                 VALUES 
                                 (:profile_id, :street, :building_number, :postal_code, :city, :province, :country)";

                $stmtInsertAddress = $this->db->prepare($sqlInsertAddress);
                $stmtInsertAddress->execute([
                    'profile_id'       => $profileId,
                    'street'           => $data['street'],
                    'building_number'  => $data['building_number'],
                    'postal_code'      => $data['postal_code'],
                    'city'             => $data['city'],
                    'province'         => $data['province'],
                    'country'          => $data['country']
                ]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Errore aggiornamento profilo utente ID $userId: " . $e->getMessage());
            return false;
        }
    }
}
