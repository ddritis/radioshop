<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <style>
        .product-grid {
            display: flex;
            gap: 20px;
        }

        .card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <nav style="background: #333; color: #fff; padding: 10px; display: flex; justify-content: space-between;">
        <div>
            <a href="index.php?page=home" style="color: #fff; text-decoration: none; font-weight: bold;">MY E-COMMERCE</a>
        </div>
        <div>
            <?php if (isset($_SESSION['userName'])): ?>
                <span>Ciao, <strong><?php echo htmlspecialchars($_SESSION['userName']); ?></strong></span>

                <a href="index.php?page=user&action=orders" style="color: #fff; margin-left: 15px; text-decoration: none;">I miei Ordini</a>

                <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                    <a href="index.php?page=admin&action=dashboard" style="color: #ffca28; margin-left: 15px;">Admin Panel</a>
                <?php endif; ?>

                <a href="index.php?page=auth&action=logout" style="color: #ff5252; margin-left: 15px; font-weight: bold;">Logout</a>
            <?php else: ?>
                <a href="index.php?page=auth&action=login" style="color: #fff; margin-left: 15px;">Accedi</a>
                <a href="index.php?page=auth&action=register" style="color: #fff; margin-left: 15px;">Registrati</a>
            <?php endif; ?>
        </div>
    </nav>

    <h1><?php echo htmlspecialchars($pageTitle); ?></h1>

    <div class="product-grid">
        <?php if (empty($products)): ?>
            <p>Non ci sono prodotti disponibili al momento.</p>
        <?php else: ?>
            <?php foreach ($products as $p): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($p['product_name']); ?></h3>
                    <p><?php echo htmlspecialchars($p['description']); ?></p>
                    <p><strong>Price: €<?php echo number_format($p['price'], 2); ?></strong></p>
                    <a href="index.php?page=product&action=show&id=<?php echo $p['id_product']; ?>">
                        View Details
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>