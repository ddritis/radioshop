<?php
// controller/StaticPageController.php

class StaticPageController extends BaseController
{
    /**
     * Visualizza la Privacy Policy
     * Rotta: index.php?page=staticPage&action=privacy
     */
    public function privacy()
    {
        $this->renderView('privacy', [
            'pageTitle' => 'Privacy Policy - RADIOSHOP'
        ]);
    }

    /**
     * Visualizza la pagina Chi Siamo
     * Rotta: index.php?page=staticPage&action=about
     */
    public function about()
    {
        $this->renderView('about', [
            'pageTitle' => 'Chi Siamo - RADIOSHOP'
        ]);
    }

    /**
     * Visualizza la pagina Contattaci
     * Rotta: index.php?page=staticPage&action=contact
     */
    public function contact()
    {
        $this->renderView('contact', [
            'pageTitle' => 'Contattaci - RADIOSHOP'
        ]);
    }

    /**
     * Gestisce l'invio del form di contatto
     * Rotta: index.php?page=staticPage&action=submitContact
     */
    public function submitContact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //  Sanitizzazione input
            $name    = htmlspecialchars(strip_tags($_POST['name'] ?? ''));
            $email   = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $message = htmlspecialchars(strip_tags($_POST['message'] ?? ''));

            // Verifica funzionale dei dati
            if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
                header("Location: index.php?page=staticPage&action=contact&status=error");
                exit();
            }

            // In una web app reale qui scriverei una mail o scriverei nel DB
            // Per ora simulo il successo e reindirizzo solamente
            header("Location: index.php?page=staticPage&action=contact&status=success");
            exit();
        }
    }
}
