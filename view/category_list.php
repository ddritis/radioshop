<!-- #0 view/category_list.php -->
<main class="container my-5">
    <div class="border-bottom pb-3 mb-4">
        <h2 class="fw-bold" style="color: var(--radioshop-purple);">
            🛒 Prodotti: <?php echo $categoryName; ?>
        </h2>
        <p class="text-muted small">Risultati filtrati per la categoria selezionata nel Lab B16.</p>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <!-- h-100: forza la card a occupare tutta l'altezza della colonna -->
                    <div class="card h-100 shadow-sm border-0 d-flex flex-column">

                        <div class="bg-light p-4 text-center">
                            <img src="public/images/products/<?php echo $product['image_path']; ?>"
                                class="img-fluid rounded"
                                style="height: 150px; object-fit: contain;"
                                alt="<?php echo $product['product_name']; ?>">
                        </div>

                        <!-- flex-grow-1: fa sì che il body occupi tutto lo spazio rimanente, 
                         spingendo il footer (e il tasto) sempre verso il basso -->
                        <div class="card-body d-flex flex-column flex-grow-1">
                            <div class="mb-2">
                                <span class="badge bg-secondary"><?php echo $product['category_name']; ?></span>
                            </div>

                            <h5 class="card-title fw-bold"><?php echo $product['product_name']; ?></h5>

                            <!-- mt-auto: in un contesto flex, assicura che il prezzo rimanga 
                             ancorato appena sopra il pulsante -->
                            <p class="card-text text-primary fs-5 mt-auto">
                                € <?php echo number_format($product['price'], 2); ?>
                            </p>
                        </div>

                        <div class="card-footer bg-transparent border-0 pb-3 mt-auto">
                            <a href="index.php?page=product&action=show&id=<?php echo $product['id_product']; ?>"
                                class="btn btn-purple w-100 shadow-sm">
                                Dettagli
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="lead">Nessun prodotto trovato per questa categoria.</p>
                <a href="index.php?page=home" class="btn btn-outline-secondary">Torna alla Home</a>
            </div>
        <?php endif; ?>
    </div>
</main>