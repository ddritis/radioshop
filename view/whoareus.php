<?php
// view/whoareus.php
// Header and Footer are managed by BaseController
?>

<main class="container-lg my-5">

    <!-- Hero Section -->
    <div class="row align-items-center mb-5 pb-4 border-bottom">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold text-uppercase mb-3">Chi Siamo</h1>
            <p class="lead fw-semibold text-secondary">Hardware per professionisti, nato in laboratorio.</p>
            <p class="fs-5">
                Radioshop non è un semplice e-commerce. Siamo un team di sistemisti e sviluppatori embedded che ha trasformato la propria passione in un hub di distribuzione per Single Board Computer (SBC).
            </p>
            <p>
                Dalla cross-compilazione di kernel Linux al testing di build custom Yocto/OpenEmbedded per PLC industriali, sappiamo esattamente di quale hardware hai bisogno perché lo configuriamo ogni giorno. Forniamo piattaforme affidabili come Raspberry Pi e Orange Pi per colmare il divario tra sviluppo e implementazione enterprise.
            </p>
        </div>
        <div class="col-lg-6 text-center">
            <!-- SVG illustration for Lab Concept -->
            <div class="p-5 bg-light rounded shadow-sm border border-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="#ffc107" class="bi bi-motherboard" viewBox="0 0 16 16">
                    <path d="M11.5 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11a.5.5 0 0 1 .5-.5M14 2a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M2 2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11a.5.5 0 0 1 .5-.5M4.5 2a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5" />
                    <path d="M5.5 0a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm-1.5 2h8A1.5 1.5 0 0 1 13.5 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 2.5 12.5v-9A1.5 1.5 0 0 1 4 2m0 1a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5z" />
                    <path d="M12.5 4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1 0-1h1a.5.5 0 0 1 .5.5M5.5 6a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1 0-1h1a.5.5 0 0 1 .5.5m7 0a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1 0-1h1a.5.5 0 0 1 .5.5M5.5 8a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1 0-1h1a.5.5 0 0 1 .5.5m7 0a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1 0-1h1a.5.5 0 0 1 .5.5M5.5 10a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1 0-1h1a.5.5 0 0 1 .5.5m7 0a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1 0-1h1a.5.5 0 0 1 .5.5M5.5 12a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1 0-1h1a.5.5 0 0 1 .5.5" />
                    <path d="M8 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 1a2 2 0 1 1 0-4 2 2 0 0 1 0 4M7.5 7a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                </svg>
                <h4 class="mt-4 fw-bold">Qualità Lab B16</h4>
            </div>
        </div>
    </div>

    <!-- Core Values Section -->
    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-warning no-zoom">
                <div class="card-body text-center p-4">
                    <h3 class="card-title fw-bold">🖥️ Hardware</h3>
                    <p class="card-text mt-3 text-muted">
                        Selezioniamo e testiamo le migliori architetture SBC per garantire affidabilità in configurazioni headless e ambienti edge-computing intensivi.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-warning no-zoom">
                <div class="card-body text-center p-4">
                    <h3 class="card-title fw-bold">🐧 Open Source</h3>
                    <p class="card-text mt-3 text-muted">
                        Tutte le nostre board sono pienamente compatibili con Debian, Red Hat Enterprise Linux e i tuoi BSP personalizzati.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-warning no-zoom">
                <div class="card-body text-center p-4">
                    <h3 class="card-title fw-bold">🛠️ Testato in Laboratorio</h3>
                    <p class="card-text mt-3 text-muted">
                        Le nostre radici sono nei laboratori tecnici. Supportiamo studenti, sistemisti e ingegneri nel realizzare i loro progetti di networking e automazione.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>