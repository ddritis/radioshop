<!-- #0 view/home.php -->
<header class="pricing-header p-3 pb-md-4 mx-auto text-center">
    <h1 class="display-4 fw-normal"><?php echo htmlspecialchars($pageTitle); ?></h1>
    <p class="fs-5 text-body-secondary">Importatore ufficiale per l'Italia di RaspberryPi e OrangePi.</p>
</header>

<main class="container-md">
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
        <?php if (empty($products)): ?>
            <div class="col-12">
                <p class="alert alert-info">Non ci sono prodotti disponibili al momento.</p>
            </div>
        <?php else: ?>
            <?php foreach ($products as $p): ?>
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm border-warning">
                        <div class="card-header py-3 text-bg-warning border-warning">
                            <h4 class="my-0 fw-normal"><?php echo htmlspecialchars($p['product_name']); ?></h4>
                        </div>

                        <?php
                        // Gestione dinamica del percorso (Architettura Web)
                        // Uso trim() per evitare che spazi vuoti nel DB rompano il confronto
                        $dbFileName = trim($p['image_path']);

                        if (!empty($dbFileName) && $dbFileName !== 'placeholder.png') {
                            // Se c'è un file specifico, lo cerco nella sottocartella products
                            $imagePath = "public/images/products/" . $dbFileName;
                        } else {
                            // Fallback: il placeholder è nella cartella images, non in products
                            $imagePath = "public/images/placeholder.png";
                        }
                        ?>

                        <img src="<?php echo htmlspecialchars($imagePath); ?>"
                            class="card-img-top p-3"
                            alt="<?php echo htmlspecialchars($p['product_name']); ?>"
                            style="height: 250px; object-fit: contain;">

                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">€<?php echo number_format($p['price'], 2); ?></h1>
                            <p class="mt-3 mb-4">
                                <?php echo htmlspecialchars(substr($p['description'], 0, 100)) . '...'; ?>
                            </p>

                            <a href="index.php?page=product&action=show&id=<?php echo $p['id_product']; ?>"
                                class="w-100 btn btn-lg btn-secondary">
                                Dettagli Prodotto
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>