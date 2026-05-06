<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if (isset($_GET['error']) && $_GET['error'] === 'missing_profile_data'): ?>
                <div class="alert alert-warning">
                    Non hai ancora inserito il tuo indirizzo e il numero di telefono.
                    Inseriscili cliccando il tasto <b>modifica</b>.
                </div>
            <?php endif; ?>
            <div class="card shadow-sm border-0 no-zoom">
                <div class="card-header bg-purple text-white py-3">
                    <h4 class="mb-0">👋 Benvenuto, <?php echo htmlspecialchars($user['first_name'] ?? $user['username']); ?></h4>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted">Nome Utente:</div>
                        <div class="col-sm-8 fw-bold">
                            <?php
                            // Verifichiamo se nome e cognome esistono, altrimenti usiamo l'email
                            if (!empty($user['first_name']) && !empty($user['last_name'])) {
                                echo htmlspecialchars($user['first_name'] . " " . $user['last_name']);
                            } else {
                                echo htmlspecialchars($user['email']);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted">Telefono:</div>
                        <div class="col-sm-8 fw-bold d-flex justify-content-between align-items-center">
                            <span>
                                <?php
                                if (!empty($user['phone'])) {
                                    echo htmlspecialchars($user['phone']);
                                } else {
                                    echo '<span class="text-danger">Telefono non inserito</span>';
                                }
                                ?>
                            </span>

                            <a href="index.php?page=user&action=editProfile" class="btn btn-sm btn-outline-primary">
                                Modifica
                            </a>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted">Indirizzo:</div>
                        <div class="col-sm-8 fw-bold d-flex justify-content-between align-items-center">
                            <span>
                                <?php
                                $addressParts = array_filter([
                                    trim(($user['street'] ?? '') . ' ' . ($user['building_number'] ?? '')),
                                    $user['postal_code'] ?? '',
                                    $user['city'] ?? '',
                                    $user['province'] ?? '',
                                    $user['country'] ?? ''
                                ]);

                                if (!empty($addressParts)) {
                                    echo htmlspecialchars(implode(', ', $addressParts));
                                } else {
                                    echo '<span class="text-danger">Indirizzo non inserito</span>';
                                }
                                ?>
                            </span>

                            <a href="index.php?page=user&action=editProfile" class="btn btn-sm btn-outline-primary">
                                Modifica
                            </a>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted">Email:</div>
                        <div class="col-sm-8"><?php echo htmlspecialchars($user['email']); ?></div>
                    </div>

                    <hr>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
                        <a href="index.php?page=user&action=orders" class="btn btn-primary me-md-2">
                            📦 I Miei Ordini
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            🗑️ Elimina Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal di conferma per la sicurezza applicativa -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Conferma Eliminazione</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sei sicuro di voler eliminare definitivamente il tuo account? Questa azione non è reversibile.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                <a href="index.php?page=user&action=deleteAccount" class="btn btn-danger">Elimina Definitivamente</a>
            </div>
        </div>
    </div>
</div>