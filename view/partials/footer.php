<!-- view/partials/footer.php -->
<div class="container-lg">
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <!-- Colonna Logo e Branding -->
            <div class="col-12 col-md">
                <img class="mb-3" src="public/images/avalonia_tux.svg" alt="Logo" width="44" height="39">
                <small class="d-block mb-1 text-uppercase fw-bold">Radio Shop &copy;</small>
                <small class="d-block mb-3 text-body-secondary">2023–2026</small>

                <!-- Bandiera Italiana (Simbolo Made in Italy / Progetto Locale) -->
                <div class="btn-group" role="group" aria-label="Italian Flag">
                    <button type="button" class="btn btn-success btn-sm" style="width: 25px; height: 15px; padding: 0;"></button>
                    <button type="button" class="btn btn-light btn-sm" style="width: 25px; height: 15px; padding: 0; border: 1px solid #ddd;"></button>
                    <button type="button" class="btn btn-danger btn-sm" style="width: 25px; height: 15px; padding: 0;"></button>
                </div>
            </div>

            <!-- Sezione 1: Catalogo e Shop -->
            <div class="col-6 col-md">
                <h5>Prodotti</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="link-secondary text-decoration-none" href="index.php?page=home">Tutti i prodotti</a></li>
                    <li><a class="link-secondary text-decoration-none" href="index.php?page=product&action=category&type=raspberry">Raspberry Pi</a></li>
                    <li><a class="link-secondary text-decoration-none" href="index.php?page=product&action=category&type=orange">Orange Pi</a></li>
                </ul>
            </div>

            <!-- Sezione 2: Supporto e Assistenza -->
            <div class="col-6 col-md">
                <h5>Assistenza</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="link-secondary text-decoration-none" href="index.php?page=maintenance&action=underConstruction">Spedizioni</a></li>
                    <li><a class="link-secondary text-decoration-none" href="index.php?page=maintenance&action=underConstruction">Resi e rimborsi</a></li>
                    <li><a class="link-secondary text-decoration-none" href="index.php?page=staticPage&action=contact">Contattaci</a></li>
                </ul>
            </div>

            <!-- Sezione 3: Legale e Tecnica -->
            <div class="col-6 col-md">
                <h5>Note Legali</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="link-secondary text-decoration-none" href="index.php?page=staticPage&action=privacy">Privacy Policy</a></li>
                    <li><a class="link-secondary text-decoration-none" href="index.php?page=staticPage&action=about">Chi Siamo</a></li>
                    <li><a class="link-secondary text-decoration-none" href="index.php?page=maintenance&action=underConstruction">Termini di Servizio</a></li>
                </ul>
            </div>
        </div>
    </footer>
</div>

<!-- Bootstrap Bundle JS (Locale) -->
<script src="public/js/bootstrap.bundle.min.js"></script>
<script src="public/js/script.js"></script>
</body>

</html>