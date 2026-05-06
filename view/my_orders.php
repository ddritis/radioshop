<!-- #0 view/my_orders.php -->
<main class="container-lg my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-uppercase mb-0">I tuoi Ordini</h1>
        <span class="badge bg-purple fs-6 p-2 shadow-sm">👤 <?php echo htmlspecialchars($_SESSION['userName']); ?></span>
    </div>

    <div class="card shadow-sm border-secondary no-zoom">
        <div class="card-header bg-secondary text-white py-3">
            <h5 class="mb-0 fw-bold">Storico Acquisti</h5>
        </div>

        <div class="card-body p-0">
            <?php if (empty($orders)): ?>
                <!-- Empty state -->
                <div class="p-5 text-center text-muted">
                    <p class="fs-5 mb-3">Non hai ancora effettuato ordini.</p>
                    <a href="index.php?page=home" class="btn btn-outline-primary fw-bold">Inizia ora!</a>
                </div>
            <?php else: ?>
                <!-- Responsive table wrapper -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Data Ordine</th>
                                <th>Stato</th>
                                <th>Fattura</th>
                                <th class="text-end">Totale Pagato</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php foreach ($orders as $o): ?>
                                <tr>
                                    <td><?php echo date("d/m/Y H:i", strtotime($o['order_date'])); ?></td>
                                    <td>
                                        <span class="badge bg-success shadow-sm">
                                            <?php echo htmlspecialchars(strtoupper($o['status'])); ?>
                                        </span>
                                    </td>
                                    <td class="fw-bold text-secondary">
                                        <?php if (!empty($o['invoice_number'])): ?>
                                            <a href="index.php?page=order&action=invoice&id=<?php echo $o['id_order']; ?>"
                                                class="text-decoration-none text-purple">
                                                📄 <?php echo htmlspecialchars($o['invoice_number']); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Non emessa</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end fw-semibold text-danger">
                                        € <?php echo number_format($o['total_amount'], 2); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-footer bg-light py-3">
            <a href="index.php?page=home" class="btn btn-secondary">Torna allo Store</a>
        </div>
    </div>
</main>