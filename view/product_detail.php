<h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
<p>Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
<hr>
<p><?php echo htmlspecialchars($product['description']); ?></p>
<p><strong>Price: €<?php echo number_format($product['price'], 2); ?></strong></p>
<p>Availability: <?php echo $product['stock_quantity']; ?> units</p>
<form action="index.php?page=cart&action=add&id=<?php echo $product['id_product']; ?>" method="POST">
    <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
    <button type="submit">Aggiungi al Carrello</button>
</form>
<a href="index.php?page=home">Back to Catalog</a>
