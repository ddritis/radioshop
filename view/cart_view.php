<h1>Il tuo Carrello 🛒</h1>

<?php if (empty($items)): ?>
    <p>Il carrello è vuoto. <a href="index.php?page=home">Torna allo shopping</a></p>
<?php else: ?>
    <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f4f4f4;">
                <th>Prodotto</th>
                <th>Prezzo Unitario</th>
                <th>Quantità</th>
                <th>Subtotale</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td>€ <?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>€ <?php echo number_format($item['subtotal'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Totale: € <?php echo number_format($total, 2); ?></h3>

    <div style="margin-top: 20px;">
        <a href="index.php?page=home">Continua lo shopping</a> |
        <a href="index.php?page=order&action=checkout" style="font-weight: bold; color: green;">Procedi all'ordine</a>
    </div>
<?php endif; ?>