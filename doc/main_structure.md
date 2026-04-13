# Project Structure

This document provides a detailed overview of the E-commerce MVC directory tree.

```text
.
│   .gitignore               # Git rules for ignored files
│   index.php                # Front Controller & Dynamic Router
│   LICENSE                  # Project license
│   README.md                # General project overview
│
├───config
│       database.json        # Local DB credentials (ignored)
│       database.json.example # Template for setup
│
├───controller
│       AdminController.php  # Dashboard & Product Management
│       AuthController.php   # Login & Register logic
│       BaseController.php   # Abstract parent controller
│       CartController.php   # Cart business logic
│       HomeController.php   # Homepage logic
│       ProductController.php # Product detail logic
│       UserController.php   # Profile & Orders logic
│
├───doc
│       main_structure.md    # This file
│
├───model
│       Database.php         # PDO Singleton class
│       DbConfig.php         # JSON Config loader
│       Order.php            # Order data model
│       Product.php          # Product data model
│       User.php             # User data model
│
└───view
        admin_dashboard.php  # Admin UI
        cart_view.php        # Cart UI
        home.php             # Catalog UI
        login.php            # Login UI
        order_success.php    # Success page UI
        product_detail.php   # Detail UI
        register.php         # Register UI
        user_profile.php     # Profile UI
```

## Standards & Conventions

```text
    Language: English (Code & Comments)

    Classes: PascalCase (e.g., DbConfig)

    Methods: camelCase (e.g., getInstance)

    Views: snake_case or simple names (e.g., home.php)

    Security: PDO with Prepared Statements & htmlspecialchars
```