```SQL
USER(
    id_user PK,
    email UNIQUE,
    password_hash,
    created_at
)

CUSTOMER(
    id_customer PK FK -> USER.id_user
)

SUPERADMIN(
    id_superadmin PK FK -> USER.id_user
)

CUSTOMER_PROFILE(
    id_profile PK,
    id_customer FK -> CUSTOMER.id_customer UNIQUE,
    first_name,
    last_name,
    phone
)

ADDRESS(
    id_address PK,
    id_profile FK -> CUSTOMER_PROFILE.id_profile,
    street,
    city,
    postal_code,
    province,
    country,
    address_type
)

CATEGORY(
    id_category PK,
    category_name UNIQUE,
    description
)

PRODUCT(
    id_product PK,
    id_category FK -> CATEGORY.id_category,
    product_name,
    description,
    stock_quantity,
    is_active
)

PRICE_LIST(
    id_price_list PK,
    id_product FK -> PRODUCT.id_product,
    price,
    valid_from,
    valid_to
)

CART(
    id_cart PK,
    id_customer FK -> CUSTOMER.id_customer UNIQUE,
    created_at
)

CART_ITEM(
    id_cart_item PK,
    id_cart FK -> CART.id_cart,
    id_product FK -> PRODUCT.id_product,
    quantity,
    UNIQUE(id_cart, id_product)
)

ORDER(
    id_order PK,
    id_customer FK -> CUSTOMER.id_customer,
    order_date,
    status
)

ORDER_ITEM(
    id_order_item PK,
    id_order FK -> ORDER.id_order,
    id_product FK -> PRODUCT.id_product,
    quantity,
    unit_price,
    UNIQUE(id_order, id_product)
)

INVOICE(
    id_invoice PK,
    id_order FK -> ORDER.id_order UNIQUE,
    invoice_date,
    invoice_number UNIQUE,
    total_amount
)
```