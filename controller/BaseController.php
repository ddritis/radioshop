<?php
// controller/BaseController.php

abstract class BaseController
{
    /**
     * Metodo helper che utilizzo per renderizzare una view e passarle i dati.
     * Gestisco l'assemblaggio di header, contenuto centrale e footer.
     * @param string $viewName Il nome del file nella cartella view (es. 'home').
     * @param array $data Array associativo di dati che estraggo in variabili.
     */
    protected function renderView($viewName, $data = [])
    {
        $viewPath = "view/{$viewName}.php";
        // Definisco i percorsi per i componenti comuni della UI
        $headerPath = "view/partials/header.php";
        $footerPath = "view/partials/footer.php";

        if (file_exists($viewPath)) {
            // Estraggo l'array in variabili singole per usarle nelle view
            extract($data);

            // Carico l'header (navbar e metadati) una sola volta per tutte le pagine
            require_once $headerPath;

            // Carico il contenuto specifico della pagina richiesta (il "centro" della pagina)
            require $viewPath;

            // Carico il footer (chiusura tag e script JS) a chiusura di tutto
            require_once $footerPath;
        } else {
            // Se la view non esiste, interrompo l'esecuzione con un errore tecnico
            die("File della view non trovato: $viewPath");
        }
    }
}
