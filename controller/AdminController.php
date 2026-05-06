<?php
// controller/AdminController.php
require_once 'BaseController.php';
require_once 'model/Product.php';

class AdminController extends BaseController
{
    /**
     * Pagina principale della dashboard Admin
     */
    public function dashboard()
    {
        // PROTEZIONE ACCESSO: Verifica autorizzazione
        if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
            // Se non è admin, reindirizzo alla home (Accesso Negato)
            header("Location: index.php?page=home&error=unauthorized");
            exit();
        }

        $productModel = new Product();
        $allProducts = $productModel->getAllActive();

        $this->renderView('admin_dashboard', [
            'pageTitle' => 'Pannello Amministratore',
            'products'  => $allProducts
        ]);
    }

    public function add()
    {
        $this->checkAdmin(); // Verifica autorizzazione
        $this->renderView('admin_add_product', ['pageTitle' => 'Aggiungi Prodotto']);
    }

    public function doAdd()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //   var_dump($_POST); 
            //   var_dump($_FILES); 
            //   die();

            // #1 Sanitizzazione e recupero dati
            $name = htmlspecialchars($_POST['product_name'] ?? '');
            $description = htmlspecialchars($_POST['product_description'] ?? '');
            $id_category = intval($_POST['id_category'] ?? 1);
            $price = floatval($_POST['price'] ?? 0);
            $stock = intval($_POST['stock'] ?? 0);

            // #2 Gestione File Upload (Sicurezza Applicativa)
            $imageName = 'placeholder.png';
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $tmpPath = $_FILES['image_file']['tmp_name'];
                $originalName = basename($_FILES['image_file']['name']);
                $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                // Validazione estensione per sicurezza
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($extension, $allowed)) {
                    $imageName = time() . "_" . $originalName; // Nome univoco
                    $destPath = "public/images/products/" . $imageName;
                    move_uploaded_file($tmpPath, $destPath);
                }
            }


            // #3 Persistenza nel DB (Model)
            $productModel = new Product();
            if ($productModel->insert($name, $price, $stock, $imageName, $id_category, $description)) {
                header("Location: index.php?page=admin&action=dashboard&status=added");
            } else {
                header("Location: index.php?page=admin&action=add&error=db");
            }
            exit();
        }
    }

    /**
     * Azione per eliminare (disattivare) un prodotto
     * URL: index.php?page=admin&action=delete&id=XX
     */
    public function delete()
    {
        $this->checkAdmin(); // solo gli admin possono eliminare

        $id = intval($_GET['id'] ?? 0); // Validazione dati: forziamo il tipo intero

        if ($id > 0) {
            $productModel = new Product();
            if ($productModel->delete($id)) {
                // Reindirizzamento con stato per la verifica funzionale
                header("Location: index.php?page=admin&action=dashboard&status=deleted");
            } else {
                header("Location: index.php?page=admin&action=dashboard&error=db");
            }
        } else {
            header("Location: index.php?page=admin&action=dashboard&error=invalid_id");
        }
        exit();
    }
}
