<!-- #0 view/user_edit_profile.php -->
<main class="container-lg my-5">
    <div class="card shadow-sm no-zoom border-purple">
        <div class="card-header bg-purple text-white py-3">
            <h3 class="mb-0 h4 text-uppercase fw-bold">✏️ Modifica Profilo</h3>
        </div>

        <div class="card-body p-4">
            <form action="index.php?page=user&action=updateProfile" method="POST">

                <h5 class="fw-bold mb-3">Contatti</h5>

                <div class="mb-3">
                    <label class="form-label fw-bold">Numero di telefono</label>
                    <input type="text"
                        name="phone"
                        class="form-control"
                        value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                        required>
                </div>

                <h5 class="fw-bold mt-4 mb-3">Indirizzo</h5>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Via</label>
                        <input type="text"
                            name="street"
                            class="form-control"
                            value="<?= htmlspecialchars($user['street'] ?? '') ?>"
                            required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Numero civico</label>
                        <input type="text"
                            name="building_number"
                            class="form-control"
                            value="<?= htmlspecialchars($user['building_number'] ?? '') ?>"
                            required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">CAP</label>
                        <input type="text"
                            name="postal_code"
                            class="form-control"
                            value="<?= htmlspecialchars($user['postal_code'] ?? '') ?>"
                            required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Città</label>
                        <input type="text"
                            name="city"
                            class="form-control"
                            value="<?= htmlspecialchars($user['city'] ?? '') ?>"
                            required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Provincia</label>
                        <input type="text"
                            name="province"
                            class="form-control"
                            value="<?= htmlspecialchars($user['province'] ?? '') ?>"
                            maxlength="2"
                            required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Paese</label>
                    <input type="text"
                        name="country"
                        class="form-control"
                        value="<?= htmlspecialchars($user['country'] ?? 'Italia') ?>"
                        required>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-purple fw-bold">
                        SALVA PROFILO
                    </button>

                    <a href="index.php?page=user&action=profile"
                        class="btn btn-outline-secondary">
                        Annulla
                    </a>
                </div>

            </form>
        </div>
    </div>
</main>