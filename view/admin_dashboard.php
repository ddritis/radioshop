<!-- view/admin_dashboard.php -->
<main class="container-lg my-5">
    <!-- Testata della Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-uppercase mb-0">Pannello di Controllo</h1>
            <p class="text-muted mb-0">Benvenuto nell'area riservata. Qui puoi gestire il catalogo prodotti.</p>
        </div>

        <!-- Contenitore per allineare gli elementi a destra -->
        <div class="d-flex align-items-center gap-3">
            <a href="index.php?page=admin&action=add" class="btn btn-success fw-bold d-flex align-items-center" style="height: 42px;">
                ➕ NUOVO PRODOTTO
            </a>
            <span class="badge bg-danger fs-6 shadow-sm d-flex align-items-center px-3" style="height: 42px;">
                🔐 Accesso Amministratore
            </span>
        </div>
    </div>


    <!-- Card contenitore per la tabella (Coerenza con il resto del sito) -->
    <div class="card shadow-sm border-dark no-zoom">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0 fw-bold">Lista Prodotti Attivi</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 10%;">ID</th>
                            <th>Nome Prodotto</th>
                            <th>Prezzo Attuale</th>
                            <th class="text-end">Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td class="fw-bold text-muted"><?php echo $p['id_product']; ?></td>
                                <td class="fw-semibold"><?php echo htmlspecialchars($p['product_name']); ?></td>
                                <td>€ <?php echo number_format($p['price'], 2); ?></td>
                                <td class="text-end">
                                    <a href="index.php?page=admin&action=edit&id=<?php echo $p['id_product']; ?>"
                                        class="btn btn-sm btn-outline-primary me-2">
                                        ✏️ Modifica
                                    </a>
                                    <a href="index.php?page=admin&action=delete&id=<?php echo $p['id_product']; ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Sei sicuro di voler nascondere il prodotto <?php echo htmlspecialchars($p['product_name']); ?> dal catalogo?');">
                                        🗑️ Elimina
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-light py-3">
            <a href="index.php?page=home" class="btn btn-secondary btn-sm">
                ⬅️ Torna al sito pubblico
            </a>
        </div>
    </div>
</main>