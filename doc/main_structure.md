# 🏗️ Project Structure - RADIOSHOP

Questo documento fornisce una panoramica dettagliata dell'albero delle directory del progetto, implementato seguendo l'architettura [MVC (Model-View-Controller)](https://it.wikipedia.org/wiki/Model-view-controller) e la separazione dei livelli [(Layered Architecture)](https://it.wikipedia.org/wiki/Astrazione_(informatica)#Architettura_a_strati).

```text
.
│   .gitignore               # Esclusioni per il versionamento Git
│   index.php                # 🚦 Front Controller & Router dinamico
│   LICENSE                  # Licenza del progetto
│   README.md                # Documentazione generale
│
├───config                   # 🔌 Configurazione del sistema e del DB
│       database.json
│       database.json.example
│
├───controller──────────────────────────────────── # ⚙️ Business Logic Layer (Gestione richieste HTTP)
│       AdminController.php       # 🛠️ Gestione pannello admin
│       AuthController.php        # 🔑 Login & Sicurezza applicativa
│       BaseController.php        # 🏗️ Classe astratta genitore
│       CartController.php        # 🛒 Logica del carrello
│       MaintenanceController.php # ⚠️ Gestione stati di errore/manutenzione
│       HomeController.php
│       OrderController.php
│       ProductController.php
│       StaticPageController.php
│       UserController.php
│       WhoareusController.php
│
├───doc────── # Documentazione tecnica e progettuale
│    │───... (documenti vari)
│
├───model────────────────────────────────────────── # 💾 Persistence Layer (Interazione con il DBMS)
│       Cart.php              # 📐 Query gestione carrello DB
│       Database.php          # 🔗 Connessione PDO (Singleton)
│       DbConfig.php
│       Order.php
│       Product.php           # 📐 Mapping tabella prodotti
│       User.php
│
├───public                   # Asset statici accessibili dal client (Frontend)
│   ├───css # 🎨
│   │       bootstrap.min.css
│   │       style.css
│   ├───images
│   │   │   avalonia_tux.svg
│   │   └───products         # Immagini dinamiche del catalogo
│   └───js # ⚡
│           bootstrap.bundle.min.js
│           script.js
│
└───view──────────────────────────────────────────── # 🖼️ Presentation Layer (Template HTML/PHP)
    │
    └───partials            # 🧩 Componenti UI riutilizzabili (Header/Footer)
            footer.php
            header.php       
    about.php
    admin_dashboard.php
    cart_view.php
    category_list.php
    home.php
    login.php
    my_orders.php
    order_success.php
    privacy.php
    product_detail.php
    register.php
    under_construction.php
    user_profile.php
    whoareus.php
```

## Standards & Conventions

```text
    Language: English (Code & Comments)

    Classes: PascalCase (e.g., DbConfig)

    Methods: camelCase (e.g., getInstance)

    Views: snake_case or simple names (e.g., home.php)

    Security: PDO with Prepared Statements & htmlspecialchars
```