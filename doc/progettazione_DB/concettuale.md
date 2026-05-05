# Elenco concettuale

## Entità principali

- Users
- Customers
- SuperAdmins
- Customer_Profiles
- Addresses
- Products
- Categories
- Price_Lists
- Carts
- Orders
- Invoices

## Entità ponte

- Cart_Items
- Order_Items

## Relazioni chiave

- Users 1:1 Customers
- Users 1:1 SuperAdmins

- Customers 1:1 Customer_Profiles
- Customer_Profiles 1:N Addresses

- Customers 1:1 Carts
- Customers 1:N Orders

- Carts 1:N Cart_Items
- Cart_Items N:1 Products

- Orders 1:N Order_Items
- Order_Items N:1 Products

- Orders 1:1 Invoices
- Orders N:1 Addresses

- Products N:1 Categories
- Products 1:N Price_Lists