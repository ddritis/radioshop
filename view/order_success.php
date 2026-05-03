<?php
// view/order_success.php
// Nota: Header e Footer sono gestiti dal BaseController
?>

<main class="container-lg my-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <!-- Icona di Successo -->
            <div class="mb-4 text-success">
                <!-- Puoi usare un'immagine o un'icona Bootstrap SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
            </div>

            <!-- Messaggio Principale -->
            <h1 class="display-5 fw-bold mb-3">Grazie per il tuo acquisto! 🎉</h1>

            <!-- Dettagli Ordine in un Alert o Card -->
            <div class="card shadow-sm border-success mb-4">
                <div class="card-body py-4">
                    <p class="fs-5 mb-2">Il tuo ordine n. <strong class="text-primary">#<?php echo htmlspecialchars($orderId); ?></strong> è stato registrato con successo.</p>
                    <p class="text-muted mb-0">È stata generata la fattura elettronica che troverai nella tua area personale.</p>
                </div>
            </div>

            <!-- Azioni Successive -->
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="index.php?page=account&action=dashboard" class="btn btn-outline-success btn-lg px-4 gap-3">Area Personale</a>
                <a href="index.php?page=home" class="btn btn-primary btn-lg px-4">Torna allo Store</a>
            </div>

        </div>
    </div>
</main>