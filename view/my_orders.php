<h1>I tuoi Ordini</h1>

<?php if (empty($orders)): ?>
    <p>Non hai ancora effettuato ordini. <a href="index.php?page=home">Inizia ora!</a></p>
<?php else: ?>
    <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f4f4f4;">
                <th>Data Ordine</th>
                <th>Stato</th>
                <th>Fattura</th>
                <th>Totale Pagato</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $o): ?>
                <tr>
                    <td><?php echo date("d/m/Y H:i", strtotime($o['order_date'])); ?></td>
                    <td><?php echo strtoupper($o['status']); ?></td>
                    <td>
                        <strong><?php echo htmlspecialchars($o['invoice_number'] ?? 'Non emessa'); ?></strong>
                    </td>
                    <td>€ <?php echo number_format($o['total_amount'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p><a href="index.php?page=home">Torna allo Store</a></p>