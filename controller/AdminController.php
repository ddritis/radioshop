<?php
// #0 controller/AdminController.php
require_once 'BaseController.php';
require_once 'model/Product.php';

class AdminController extends BaseController
{
    /**
     * Pagina principale della dashboard Admin
     */
    public function dashboard()
    {
        // #1 Verifica autorizzazione alla dashboard di amministratore
        if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
            // #2 Se non è admin, reindirizzo alla home (accesso negato)
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
        $this->checkAdmin(); // #3 Verifica autorizzazione
        $this->renderView('admin_add_product', ['pageTitle' => 'Aggiungi Prodotto']);
    }

    public function doAdd()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           /*var_dump($_POST); 
              var_dump($_FILES); 
              die(); */

            // #4 Sanitizzazione e recupero dati
            $name = htmlspecialchars($_POST['product_name'] ?? '');
            $description = htmlspecialchars($_POST['product_description'] ?? '');
            $id_category = intval($_POST['id_category'] ?? 1);
            $price = floatval($_POST['price'] ?? 0);
            $stock = intval($_POST['stock'] ?? 0);

            // #5 Gestione file upload
            $imageName = 'placeholder.png';
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $tmpPath = $_FILES['image_file']['tmp_name'];
                $originalName = basename($_FILES['image_file']['name']);
                $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                // #6 Validazione estensione per sicurezza [si può fare di meglio ma il tempo è poco :-) ]
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($extension, $allowed)) {
                    $imageName = time() . "_" . $originalName; // #7 Nome univoco sfruttando timestamp
                    $destPath = "public/images/products/" . $imageName;
                    move_uploaded_file($tmpPath, $destPath);
                }
            }


            // #8 inserimento nel DB (Model)
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
        $this->checkAdmin(); // #9 Solo gli admin possono eliminare

        $id = intval($_GET['id'] ?? 0); // #10 Validazione dati: forzo il tipo intero

        if ($id > 0) {
            $productModel = new Product();
            if ($productModel->delete($id)) {
                // #11 Reindirizzamento con stato di uscita
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
