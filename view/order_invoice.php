<!-- #0 view/order_invoice.php -->
<main class="container my-5">
    <div class="card shadow-sm border-purple no-zoom">
        <div class="card-header bg-purple text-white text-center py-3">
            <h4 class="mb-0 text-uppercase fw-bold">Dettaglio Fattura: <?php echo htmlspecialchars($order['invoice_number']); ?></h4>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-6">
                    <h5 class="text-muted small text-uppercase">Intestatario Fattura</h5>
                    <p class="fw-bold fs-5 mb-0">
                        <?php echo htmlspecialchars($order['first_name'] . " " . $order['last_name']); ?>
                    </p>
                    <p class="text-muted"><?php echo htmlspecialchars($order['email']); ?></p>
                </div>
                <div class="col-6 text-end">
                    <h5 class="text-muted small text-uppercase">Data Documento</h5>
                    <p class="fw-bold"><?php echo date("d/m/Y H:i", strtotime($order['order_date'])); ?></p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-6">
                    <h5 class="text-muted small text-uppercase">Data Ordine</h5>
                    <p class="fw-bold fs-5"><?php echo date("d/m/Y H:i", strtotime($order['order_date'])); ?></p>
                </div>
                <div class="col-6 text-end">
                    <h5 class="text-muted small text-uppercase">Totale Documento</h5>
                    <p class="fs-3 fw-bold text-danger">€ <?php echo number_format($order['total_amount'], 2); ?></p>
                </div>
            </div>

            <hr class="my-4">
            <p class="mb-4">Stato dell'ordine: <span class="badge bg-success shadow-sm"><?php echo strtoupper($order['status']); ?></span></p>

            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead class="table-light text-uppercase small">
                        <tr>
                            <th>Prodotto</th>
                            <th class="text-center">Quantità</th>
                            <th class="text-end">Prezzo Unit.</th>
                            <th class="text-end">Subtotale</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="fw-semibold"><?php echo htmlspecialchars($item['name']); ?></td>
                                <td class="text-center"><?php echo $item['quantity']; ?></td>
                                <td class="text-end">€ <?php echo number_format($item['unit_price'], 2); ?></td>
                                <td class="text-end fw-bold">
                                    € <?php echo number_format($item['quantity'] * $item['unit_price'], 2); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light text-center py-3">
            <button onclick="window.print()" class="btn btn-outline-dark me-2">🖨️ Stampa</button>
            <a href="index.php?page=user&action=orders" class="btn btn-purple">Torna ai miei ordini</a>
        </div>
    </div>
</main>