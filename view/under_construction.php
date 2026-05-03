<?php
// view/under_construction.php
?>
<main class="container-lg text-center my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <!-- Immagine centrata e responsive -->
            <img src="<?php echo $imagePath; ?>"
                class="img-fluid mb-4 shadow rounded"
                alt="Pagina in manutenzione">

            <!-- Alert con stile Radioshop -->
            <div class="alert alert-warning border-warning shadow-sm py-4">
                <h2 class="fw-bold">⚠️ PAGINA IN COSTRUZIONE ⚠️</h2>
                <p class="fs-5 mb-0">
                    Siamo nel pieno della fase di sviluppo (Lab B16). <br>
                    Tornate presto a trovarci per scoprire le nuove funzionalità di <strong>Radioshop</strong>.
                </p>
            </div>

            <a href="index.php?page=home" class="btn btn-warning btn-lg fw-bold mt-3 px-5 shadow-sm">
                TORNA AL CATALOGO
            </a>
        </div>
    </div>
</main>