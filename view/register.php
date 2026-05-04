<?php
// view/register.php
// Nota: Header e Footer sono caricati automaticamente dal BaseController
?>

<div class="container-sm mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-warning no-zoom">
                <div class="card-header bg-warning text-center py-3">
                    <h2 class="mb-0 h4 text-uppercase fw-bold">Registra un nuovo account</h2>
                </div>
                <div class="card-body p-4">

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Errore:</strong> <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?page=auth&action=register" method="POST" class="needs-validation">

                        <!-- Uso le classi form-control di Bootstrap per l'aspetto Radioshop -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nome</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Inserisci il tuo nome" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Cognome</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Inserisci il tuo cognome" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-warning-subtle" id="basic-addon1">@</span>
                                <input type="email" name="email" class="form-control" placeholder="email@esempio.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimo 8 caratteri" required>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-warning fw-bold text-uppercase">Crea Account</button>
                        </div>

                        <div class="text-center mt-3 border-top pt-3">
                            <p class="small">Hai già un account? <a href="index.php?page=auth&action=login" class="text-decoration-none fw-bold text-primary">Accedi qui</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>