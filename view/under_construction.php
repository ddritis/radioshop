<?php
// view/under_construction.php
?>
<main class="container-lg text-center my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <!-- Alert con stile Radioshop -->
            <div class="alert alert-warning border-warning shadow-sm py-3">
                <h2 class="fw-bold">⚠️ PAGINA IN COSTRUZIONE ⚠️</h2>
                <p class="fs-5 mb-0">
                    Siamo nel pieno della fase di sviluppo (Lab B16). <br>
                    Tornate presto a trovarci per scoprire le nuove funzionalità di <strong>Radioshop</strong>.
                </p>
            </div>

            <!-- Immagine scalata al 50% della larghezza del contenitore -->
            <div class="d-flex justify-content-center">
                <img src="<?php echo $imagePath; ?>"
                    class="img-fluid mb-4 shadow rounded w-50"
                    alt="Pagina in manutenzione">
            </div>

            <a href="index.php?page=home" class="btn btn-purple btn-lg fw-bold mt-3 px-5 shadow-sm">
                TORNA ALLA HOMEPAGE</a>
        </div>
    </div>
</main>