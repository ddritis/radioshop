<!-- #0 view/admin_add_product.php -->
<main class="container-lg my-5">
    <div class="card shadow-sm no-zoom border-purple">
        <div class="card-header bg-purple text-white py-3">
            <h3 class="mb-0 h4 text-uppercase fw-bold">➕ Aggiungi Nuovo Prodotto</h3>
        </div>
        <div class="card-body p-4">
            <!-- #1 necessario enctype="multipart/form-data" per il caricamento file -->
            <form action="index.php?page=admin&action=doAdd" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nome Prodotto</label>
                    <input type="text" name="product_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Descrizione</label>
                    <input type="text" name="product_description" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Categoria</label>
                    <select name="id_category" class="form-select" required>
                        <option value="1">Raspberry Pi</option>
                        <option value="2">Orange Pi</option>
                        <option value="3">altri-sbc</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Prezzo (€)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Quantità Stock</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Immagine Prodotto</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*" required>
                    <div class="form-text">Il file verrà salvato in public/images/products/</div>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-purple fw-bold">SALVA PRODOTTO</button>
                    <a href="index.php?page=admin&action=dashboard" class="btn btn-outline-secondary">Annulla</a>
                </div>
            </form>
        </div>
    </div>
</main>