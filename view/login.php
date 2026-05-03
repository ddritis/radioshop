<?php
// view/login.php
// Nota: Header e Footer sono gestiti dal BaseController
?>

<main class="container-lg my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <!-- La card crea il contenitore visivo tipico dei sistemi professionali -->
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-center py-3">
                    <h1 class="h4 mb-0 fw-bold text-uppercase">Accedi al tuo account</h1>
                </div>
                <div class="card-body p-4">

                    <!-- Gestione Errori con componente Alert di Bootstrap -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger py-2 small" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i> <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?page=auth&action=login" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="esempio@email.it" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Inserisci password" required>
                        </div>

                        <!-- Bottone Full-Width per Mobile-First design -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary fw-bold">ACCEDI</button>
                        </div>
                    </form>

                    <div class="text-center mt-3 pt-3 border-top">
                        <p class="small mb-0 text-muted">
                            Non hai un account? <a href="index.php?page=auth&action=register" class="text-decoration-none fw-bold text-primary">Registrati qui</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>