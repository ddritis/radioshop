# Import database instructions

Use cmd.exe, you can start from PWSH

`mysql -u root -p -h 127.0.0.1 -P 63306 -e "CREATE DATABASE ecommerce_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"`


`mysql -u root -h 127.0.0.1 -P 63306 ecommerce_db < .\doc\progettazione_DB\ecommerce_db.sql`

Change port, username.