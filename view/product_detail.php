<?php
// view/product_detail.php
?>
<main class="container-lg my-5">
    <div class="row align-items-center">
        <!-- Colonna Immagine -->
        <div class="col-md-6 text-center">
            <img src="public/images/products/<?php echo htmlspecialchars($product['image_path'] ?? 'placeholder.png'); ?>"
                class="img-fluid rounded shadow-sm border"
                alt="<?php echo htmlspecialchars($product['product_name']); ?>">
        </div>

        <!-- Colonna Info -->
        <div class="col-md-6">
            <h1 class="display-5 fw-bold"><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <h2 class="text-danger mb-4">€<?php echo number_format($product['price'], 2); ?></h2>

            <div class="p-3 bg-light rounded border mb-4">
                <h5 class="fw-bold border-bottom pb-2">SPECIFICHE TECNICHE</h5>
                <ul class="list-unstyled">
                    <?php
                    $specs = explode("\n", $product['description']);
                    foreach ($specs as $spec):
                        if (trim($spec) != ""): ?>
                            <li class="mb-2">🔹 <?php echo htmlspecialchars($spec); ?></li>
                    <?php endif;
                    endforeach; ?>
                </ul>
            </div>

            <div class="d-grid gap-2">
                <a href="index.php?page=cart&action=add&id=<?php echo $product['id_product']; ?>" class="btn btn-warning btn-lg fw-bold">AGGIUNGI AL CARRELLO</a>
                <a href="index.php?page=home" class="btn btn-outline-secondary">Torna al Catalogo</a>
            </div>
        </div>
    </div>
</main>