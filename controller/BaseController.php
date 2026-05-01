<?php
// controller/BaseController.php

abstract class BaseController
{
    /**
     * Metodo helper che utilizzo per renderizzare una view e passarle i dati.
     * @param string $viewName Il nome del file nella cartella view (in snake_case).
     * @param array $data Array associativo di dati che estraggo in variabili.
     */
    protected function renderView($viewName, $data = [])
    {
        $viewPath = "view/{$viewName}.php";

        if (file_exists($viewPath)) {
            // Estraggo le chiavi dell'array come variabili per la view (es. ['products' => $list] diventa $products)
            extract($data);

            // Includo il file della view per mostrarlo a video
            require_once $viewPath;
        } else {
            // Se il file non esiste, interrompo l'esecuzione con un messaggio di errore
            die("File della view non trovato: $viewPath");
        }
    }
}
