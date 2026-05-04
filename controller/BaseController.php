<?php
// controller/BaseController.php

abstract class BaseController
{
    /**
     * Metodo helper per renderizzare una view e passare i dati.
     * Gestisce l'assemblaggio di header, contenuto centrale e footer.
     */
    protected function renderView($viewName, $data = [])
    {
        $viewPath = "view/{$viewName}.php";
        $headerPath = "view/partials/header.php";
        $footerPath = "view/partials/footer.php";

        // Verifica funzionale: controllo l'esistenza del file sul filesystem
        if (file_exists($viewPath)) {
            // Estraggo l'array in variabili singole per le view
            extract($data);

            require_once $headerPath;
            require $viewPath;
            require_once $footerPath;
        } else {
            /**
             * GESTIONE ERRORI E VALIDAZIONE: 
             * Se la view manca, effettuo un redirect alla pagina di manutenzione.
             * Evito di mostrare errori di sistema (die) per migliorare la sicurezza applicativa.
             */
            header("Location: index.php?page=maintenance&action=underConstruction");
            exit();
        }
    }
}
