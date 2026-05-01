<h1>Registra un nuovo account</h1>

<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form action="index.php?page=auth&action=register" method="POST">
    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Crea Account</button>
</form>

<p>Hai già un account? <a href="index.php?page=auth&action=login">Accedi qui</a></p>