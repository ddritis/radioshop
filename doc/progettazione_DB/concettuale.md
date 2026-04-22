Entità principali

Utente
Cliente
SuperAdmin
Anagrafica
Indirizzo
Prodotto
Categoria
Listino
Magazzino
Carrello
Ordine
Fattura

Entità ponte

RigaCarrello
RigaOrdine

Relazioni chiave

Cliente 1:1 Carrello
Cliente 1:N Ordine
Cliente 1:1 / 1:N Anagrafica
Anagrafica 1:N Indirizzo
Prodotto N:1 Categoria
Prodotto 1:N Listino
Prodotto N:1 Magazzino
Carrello 1:N RigaCarrello
RigaCarrello N:1 Prodotto
Ordine 1:N RigaOrdine
RigaOrdine N:1 Prodotto
Ordine 1:1 Fattura

