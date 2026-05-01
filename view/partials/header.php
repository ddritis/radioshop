<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'RADIOSHOP'); ?></title>

    <!-- 1. Bootstrap CSS (Fondamentale per la grafica) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- 2. CSS personalizzato (Se presente in public/css) -->
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <!-- navbar container -->
    <nav class="navbar navbar-expand-lg bg-warning mb-3">
        <div class="container-lg">
            <!-- Logo e Brand -->
            <a class="navbar-brand d-flex align-items-center" href="index.php?page=home">
                <img src="public/images/avalonia_tux.svg" alt="Logo" width="30" height="24">
                <span class="ms-2 fw-bold">RADIOSHOP</span>
            </a>

            <!-- Pulsante Hamburger (Toggler) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarRadioshop" aria-controls="navbarRadioshop"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenitore Collassabile -->
            <div class="collapse navbar-collapse" id="navbarRadioshop">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?page=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=whoareus">Chi siamo</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Prodotti
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Raspberry Pi</a></li>
                            <li><a class="dropdown-item" href="#">Orange Pi</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Autenticazione con protezione XSS (Sanitizzazione input) -->
                <div class="d-flex align-items-center mt-3 mt-lg-0">
                    <?php if (isset($_SESSION['userId'])): ?>
                        <span class="me-3 small">Ciao, <strong><?php echo htmlspecialchars($_SESSION['userName']); ?></strong></span>
                        <a href="index.php?page=auth&action=logout" class="btn btn-outline-danger btn-sm">Logout</a>
                    <?php else: ?>
                        <a href="index.php?page=auth&action=login" class="btn btn-outline-dark me-2 btn-sm">Accedi</a>
                        <a href="index.php?page=auth&action=register" class="btn btn-dark btn-sm">Registrati</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>