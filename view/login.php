<h1>Accedi al tuo account</h1>

<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form action="index.php?page=auth&action=login" method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Accedi</button>
</form>

<p>Non hai un account? <a href="index.php?page=auth&action=register">Registrati qui</a></p>