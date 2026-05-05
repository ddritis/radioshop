
`127.0.0.1/ecommerce_db/`		

`http://localhost/phpmyadmin/index.php?route=/database/sql&db=ecommerce_db`

Your SQL query has been executed successfully.

```SQL
SHOW TABLES;



addresses	
cart_items	
carts	
categories	
customer_profiles	
customers	
invoices	
order_items	
orders	
price_lists	
products	
superadmins	
users	
```

---

```powershell
mysqldump -u user -p --no-data ecommerce_db > schema.sql
```

