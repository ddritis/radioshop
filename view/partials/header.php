<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'RADIOSHOP'); ?></title>

    <!-- 1. Bootstrap CSS (Caricamento locale per funzionamento offline) -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">

    <!-- 2. CSS personalizzato (Caricato dopo per sovrascrivere Bootstrap) -->
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

                        <!-- Link al Profilo Utente (user_profile.php) -->
                        <span class="me-3 small">Ciao,
                            <a href="index.php?page=user&action=orders" class="text-dark text-decoration-none fw-bold text-uppercase" title="Area Personale">
                                👤 <?php echo htmlspecialchars($_SESSION['userName']); ?>
                            </a>
                        </span>

                        <!-- Pulsante Carrello (cart_view.php) -->
                        <a href="index.php?page=cart&action=index" class="btn btn-outline-dark btn-sm me-3 d-flex align-items-center">
                            🛒 <span class="ms-1 fw-bold">Carrello</span>
                        </a>

                        <!-- Logout -->
                        <a href="index.php?page=auth&action=logout" class="btn btn-danger btn-sm shadow-sm">Logout</a>

                    <?php else: ?>
                        <!-- Utente non loggato -->
                        <a href="index.php?page=auth&action=login" class="btn btn-outline-dark me-2 btn-sm shadow-sm">Accedi</a>
                        <a href="index.php?page=auth&action=register" class="btn btn-dark btn-sm shadow-sm">Registrati</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <?php
    // Cookie
    if (isset($_COOKIE['gdpr_accepted']) && $_COOKIE['gdpr_accepted'] === 'true') {
        // NOP
    }
    ?>
    <!-- GDPR Cookie Banner -->
    <div id="cookieConsent"
        class="bg-danger text-white py-3 fixed-bottom border-top border-danger shadow-lg"
        style="display: none; z-index: 1050;">

        <div class="container-lg d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

            <div class="fs-5 text-center text-md-start flex-grow-1">
                <span class="d-inline-block mx-auto mx-md-0" style="max-width: 960px;">
                    🍪 <strong>Informativa:</strong> Questo sito utilizza esclusivamente cookie tecnici necessari al funzionamento del carrello,
                    alla gestione delle sessioni e alla sicurezza. In base al Regolamento (UE) 2016/679 (GDPR),
                    tali cookie non richiedono il consenso dell’utente.
                </span>
            </div>

            <div class="flex-shrink-0">
                <button id="btnAcceptCookies" class="btn btn-warning btn-sm fw-bold px-4">
                    Ho capito
                </button>
            </div>

        </div>
    </div>

</body>