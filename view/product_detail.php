<?php
// #0 view/product_detail.php
// #1 Assumo che $product sia stato recuperato dal Controller tramite il Model

// #2 Logica di routing degli asset (come fatto in homepage)
$dbFileName = isset($product['image_path']) ? trim($product['image_path']) : '';

if (!empty($dbFileName) && $dbFileName !== 'placeholder.png') {
    $imagePath = "public/images/products/" . $dbFileName;
} else {
    $imagePath = "public/images/placeholder.png";
}
?>

<main class="container-lg my-5">
    <div class="row align-items-center">
        <!-- #3 Colonna immagine -->
        <div class="col-md-6 text-center mb-4 mb-md-0">
            <div class="p-3 border rounded shadow-sm bg-white">
                <img src="<?php echo htmlspecialchars($imagePath); ?>"
                    class="img-fluid rounded"
                    alt="<?php echo htmlspecialchars($product['product_name'] ?? 'Prodotto'); ?>"
                    style="max-height: 500px; object-fit: contain;">
            </div>
        </div>

        <!-- #4 Colonna info -->
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?page=home">Catalogo</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['category_name'] ?? 'SBC'); ?></li>
                </ol>
            </nav>

            <h1 class="display-5 fw-bold"><?php echo htmlspecialchars($product['product_name'] ?? 'Prodotto non trovato'); ?></h1>
            <h2 class="text-danger mb-4 fw-bold">€<?php echo number_format($product['price'] ?? 0, 2); ?></h2>

            <div class="p-4 bg-light rounded border mb-4">
                <h5 class="fw-bold border-bottom pb-2 mb-3">
                    <i class="bi bi-cpu"></i> SPECIFICHE TECNICHE
                </h5>
                <ul class="list-unstyled">
                    <?php
                    // #5 Validazione dati: trasformo la descrizione in lista
                    $description = $product['description'] ?? '';
                    $specs = explode("\n", $description);

                    foreach ($specs as $spec):
                        $cleanSpec = trim($spec);
                        if ($cleanSpec != ""): ?>
                            <li class="mb-2 d-flex align-items-start">
                                <span class="me-2">🔹</span>
                                <span><?php echo htmlspecialchars($cleanSpec); ?></span>
                            </li>
                    <?php endif;
                    endforeach; ?>
                </ul>
            </div>

            <div class="d-grid gap-3">
                <a href="index.php?page=cart&action=add&id=<?php echo (int)($product['id_product'] ?? 0); ?>"
                    class="btn btn-warning btn-lg fw-bold shadow-sm">
                    <i class="bi bi-cart-plus"></i> AGGIUNGI AL CARRELLO
                </a>
                <a href="index.php?page=home" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Torna al Catalogo
                </a>
            </div>
        </div>
    </div>
</main>