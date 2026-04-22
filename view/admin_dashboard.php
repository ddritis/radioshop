<h1>Pannello di Controllo</h1>
<p>Benvenuto nell'area riservata. Qui puoi gestire il catalogo prodotti.</p>

<hr>

<h3>Lista Prodotti Attivi</h3>
<table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: #eee;">
            <th>ID</th>
            <th>Nome Prodotto</th>
            <th>Prezzo Attuale</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?php echo $p['id_product']; ?></td>
                <td><?php echo htmlspecialchars($p['product_name']); ?></td>
                <td>€ <?php echo number_format($p['price'], 2); ?></td>
                <td>
                    <a href="index.php?page=admin&action=edit&id=<?php echo $p['id_product']; ?>">Modifica</a> |
                    <a href="#" style="color: red;">Elimina</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>
<a href="index.php?page=home">Torna al sito pubblico</a>