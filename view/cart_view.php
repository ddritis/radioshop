<main class="container-lg my-5">
    <h1 class="mb-4 fw-bold">Il tuo Carrello 🛒</h1>

    <?php if (empty($items)): ?>
        <div class="alert alert-warning shadow-sm" role="alert">
            Il carrello è vuoto. <a href="index.php?page=home" class="alert-link">Torna allo shopping</a>
        </div>
    <?php else: ?>
        <!-- Wrapper per la responsività su dispositivi mobili -->
        <div class="table-responsive shadow-sm rounded border">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Prodotto</th>
                        <th scope="col" class="text-end">Prezzo Unitario</th>
                        <th scope="col" class="text-center">Quantità</th>
                        <th scope="col" class="text-end">Subtotale</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td class="text-end">€ <?php echo number_format($item['price'], 2); ?></td>
                            <td class="text-center"><?php echo $item['quantity']; ?></td>
                            <td class="text-end fw-semibold">€ <?php echo number_format($item['subtotal'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-warning">
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Totale:</td>
                        <td class="text-end fw-bold fs-5 text-danger">€ <?php echo number_format($total, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Controlli di navigazione inferiori -->
        <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-4">
            <a href="index.php?page=home" class="btn btn-outline-secondary fw-semibold">
                Continua lo shopping
            </a>
            <a href="index.php?page=order&action=checkout" class="btn btn-success btn-lg fw-bold shadow-sm">
                Procedi all'ordine
            </a>
        </div>
    <?php endif; ?>
</main>