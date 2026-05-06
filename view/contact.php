<!-- #0 view/contact.php -->
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm border-purple no-zoom">
                <div class="card-header bg-purple text-white py-3">
                    <h3 class="mb-0 h4 text-uppercase fw-bold text-center">Inviaci un messaggio</h3>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Hai bisogno di supporto tecnico per il tuo Raspberry Pi o vuoi informazioni sui prodotti? Compila il form sottostante.</p>

                    <?php if (isset($_GET['status'])): ?>
                        <?php if ($_GET['status'] === 'success'): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>✅ Inviato!</strong> Il tuo messaggio è stato ricevuto correttamente.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php elseif ($_GET['status'] === 'error'): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>❌ Errore:</strong> Controlla i dati inseriti e riprova.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Il form punta a una futura action di gestione POST -->
                    <form action="index.php?page=staticPage&action=submitContact" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nome</label>
                                <input type="text" name="name" class="form-control" placeholder="Tuo nome" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="email@esempio.it" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Oggetto</label>
                            <select name="subject" class="form-select">
                                <option value="support">Supporto Tecnico</option>
                                <option value="sales">Informazioni Commerciali</option>
                                <option value="other">Altro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Messaggio</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Descrivi la tua richiesta..." required></textarea>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-purple fw-bold text-uppercase">Invia Richiesta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>